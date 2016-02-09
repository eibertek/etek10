<?php

namespace Etk\Bundle\UsuariosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\Security\Core\SecurityContext as SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Etk\Bundle\UsuariosBundle\Entity\Usuarios as UsuarioEntity;
use Etk\Bundle\UsuariosBundle\Entity\Activationlink as ActivationEntity;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user = "";
        return $this->render('EtkUsuariosBundle:Default:index.html.twig', array('name' => $user));
    }
    

    public function loginAction(Request $request)
    {
        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            return $this->redirect(
                          $this->generateUrl("etk_usuarios_homepage")
                );
        }
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        $request->getSession()->remove(SecurityContext::AUTHENTICATION_ERROR);
        $result =  array(
            'last_username' => $request->getSession()->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        );
       // return $result;
        return $this->render('EtkUsuariosBundle:Default:login.html.twig', $result);        
    }

    public function securityCheckAction()
    {
        // The security layer will intercept this request
 
    }

    /**  
     *
     * @return View
     *      
     **/
    public function registerUserAction(Request $request)
    {
        $usuarios = new UsuarioEntity();
        $form = $this->createForm(new \Etk\Bundle\UsuariosBundle\Form\UsuariosType(), $usuarios, Array('action'=>'','method'=>'POST')
                                  );
        $form->handleRequest($request);
        if ($request->isMethod('POST')) {
            if ($form->isValid()) {
                // guardar la tarea en la base de datos
                $usuarios = $form->getData();
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($usuarios);
                $pasword = $encoder->encodePassword($usuarios->getPlainPassword(), $usuarios->getSalt());
                $usuarios->setPassword($pasword);
                $usuarios->setCreateddate(new \DateTime("now"));
                $usuarios->setRole('ROLE_USER');
                $usuarios->setStatus(UsuarioEntity::NOT_VALIDATED);
                if($this->validate($usuarios)){
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($usuarios);
                    $em->flush();
                    $activationLink = new ActivationEntity();
                    $activationLink->setUserId($usuarios->getId());
                $activationLink->setExpireDate( new \DateTime('tomorrow'));
                    $em->persist($activationLink);
                    $em->flush();
                    $this->sendmail($usuarios,$activationLink->getId());
                    return $this->render('EtkUsuariosBundle:messages:success.html.twig', array(  'msg' => 'Se ha creado el usuario con exito', 'path' => 'etk_usuarios_login'));
                }else{
                    $this->get('session')->getFlashBag()->add('error', 'El Usuario que intenta crear ya está registrado, si no recuerda su contraseña vaya al login y haga click en recuperar contraseña');
                    return $this->render('EtkUsuariosBundle:Default:nuevo.html.twig', array(  'form' => $form->createView(),));
                }
            }else{
                return $this->render('EtkUsuariosBundle:Default:nuevo.html.twig', array(  'form' => $form->createView(),));
            }

        }else{
            return $this->render('EtkUsuariosBundle:Default:nuevo.html.twig', array(  'form' => $form->createView(),));
        }        
    }

    public function logoutAction()
    {
        // The security layer will intercept this request
    }
    
   
    private function sendmail($usuarios, $activationLinkId){
        $message = \Swift_Message::newInstance()
        ->setSubject('Bienvenido a Eibertek!')
        ->setFrom('altas@eibertek.com')
        ->setTo($usuarios->getEmail())
        ->setBody(
              $this->renderView(
                'EtkUsuariosBundle:messages:AltaEmail.html.twig',
                array('usuario' => $usuarios, 'link' => $activationLinkId)
            ),
            'text/html'
        );
    $this->get('mailer')->send($message);
    }
    private function validate($usuarios){
        $search = $this->getDoctrine()->getRepository('EtkUsuariosBundle:Usuarios');
        $criteria = (array('email' => $usuarios->getEmail(), 'username'=>$usuarios->getUsername()));
        $users = $search->findBy($criteria);
        if(count($users)>=1){
            return false;
        }else{
            return true;
        }
    }
    
    public function activarAction()
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('
            SELECT u.username, u.nombre, u.id as userId,  u.apellido, u.status , a.expireDate, a.id as alinkId 
            FROM EtkUsuariosBundle:Usuarios u
            inner join EtkUsuariosBundle:Activationlink a
            with u.id = a.userId 
            WHERE a.id = :id
        ');

        $query->setParameter('id', $_GET['id']);
        $dataquery = $query->getResult();
        if (count($dataquery)==0){
               $this->get('session')->getFlashBag()->add('notice', 'El link no es valido');            
               return $this->redirectToRoute('etk_usuarios_homepage');
        }
        $datetime1 = $dataquery[0]['expireDate'];
        $datetime2 = new \DateTime();
        $interval = $datetime2->diff($datetime1);
        if ($datetime1 >= $datetime2 &&  $dataquery[0]['status'] === UsuarioEntity::NOT_VALIDATED){
            //Se activa al usuario
            $usuario = $this->getDoctrine()->getRepository('EtkUsuariosBundle:Usuarios')->find($dataquery[0]['userId']); 
            $link = $this->getDoctrine()->getRepository('EtkUsuariosBundle:Activationlink')->find($dataquery[0]['alinkId']); 
            $usuario->setStatus(UsuarioEntity::ACTIVE);
            $em->remove($link);
            $em->persist($usuario);
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice', 'Usuario Activado con exito');
        }else{
            $this->get('session')->getFlashBag()->add('notice', 'El link ha caducado');            
        }
      //  return $this->render('EtkUsuariosBundle:Default:activar.html.twig', array(  'data' => $dataquery[0])); 
       return $this->redirectToRoute('etk_usuarios_homepage');
    }
    
    
}
