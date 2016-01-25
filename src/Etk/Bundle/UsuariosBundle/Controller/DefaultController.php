<?php

namespace Etk\Bundle\UsuariosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\Security\Core\SecurityContext as SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Etk\Bundle\UsuariosBundle\Entity\Usuarios as UsuarioEntity;
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
                $pasword = $encoder->encodePassword($usuarios->getPassword(), $usuarios->getSalt());
                $usuarios->setPassword($pasword);
                $usuarios->setCreateddate(new \DateTime("now"));
                $usuarios->setRole('ROLE_USER');
                $usuarios->setStatus(UsuarioEntity::NOT_VALIDATED);
                if($this->validate($usuarios)){
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($usuarios);
                    $em->flush();
                    $search = $this->getDoctrine()->getRepository('EtkUsuariosBundle:Usuarios')->findBy(array('email' => $usuarios->getEmail(), 'username'=>$usuarios->getUsername()));
                    $usuarios->setId($search[0]->getId());
                    $this->sendmail($usuarios);
                    return $this->render('EtkUsuariosBundle:messages:success.html.twig', array(  'msg' => 'Se ha creado el usuario con exito', 'path' => 'etk_usuarios_login'));
                }else{
                    $this->get('session')->getFlashBag()->add('error', 'EL Usuario que intenta crear ya está registrado, si no recuerda su contraseña vaya al login y haga click en recuperar contraseña');
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
    
    private function avoidDuplicatesFlash(){
        $session = new \Symfony\Component\HttpFoundation\Session\Session();
        var_dump($session->getFlashBag()->get('notice'));  
        if($session->getFlashBag()->get('notice')){
            return false;
        }else{
            // set flash messages
            $session->getFlashBag()->add('notice', 'Usuario Ya creado');
            return true;
        }
    }
    
    private function sendmail($usuarios){
        $message = \Swift_Message::newInstance()
        ->setSubject('Bienvenido a Eibertek!')
        ->setFrom('altas@eibertek.com')
        ->setTo($usuarios->getEmail())
        ->setBody(
              $this->renderView(
                'EtkUsuariosBundle:messages:AltaEmail.html.twig',
                array('usuario' => $usuarios)
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
}
