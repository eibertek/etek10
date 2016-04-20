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
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $form = $this->createForm(new \Etk\Bundle\UsuariosBundle\Form\UsuariosType(), $usuarios, Array('action'=>$this->generateUrl('etk_usuarios_registerUser'),'method'=>'POST')
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
                if( $this->get('etk_admin.usuarios')->validate($usuarios)){
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($usuarios);
                    $em->flush();
                    $activationLink = new ActivationEntity();
                    $activationLink->setUserId($usuarios->getId());
                    $activationLink->setExpireDate( new \DateTime('tomorrow'));
                    $em->persist($activationLink);
                    $em->flush();
                    $this->get('etk_admin.usuarios')->sendmail($usuarios,$activationLink->getId());
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
    
   
    public function activarAction()
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('
            SELECT u.username, u.nombre, u.id as userId,  u.apellido, u.status , a.expireDate, a.id as alinkId, a.method as alinkMethod 
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
        if ($datetime1 >= $datetime2 ){
            //Se activa al usuario
            if($dataquery[0]['alinkMethod'] === ActivationEntity::METHOD_PASSWORD )
            {
                    $link = $this->getDoctrine()->getRepository('EtkUsuariosBundle:Activationlink')->find($dataquery[0]['alinkId']); 
                    $em->remove($link);
                    $em->flush();
                    return $this->restorePasswordAction($dataquery[0]['userId']);
            } elseif ( $dataquery[0]['status'] === UsuarioEntity::NOT_VALIDATED) {
                    $usuario = $this->getDoctrine()->getRepository('EtkUsuariosBundle:Usuarios')->find($dataquery[0]['userId']); 
                    $link = $this->getDoctrine()->getRepository('EtkUsuariosBundle:Activationlink')->find($dataquery[0]['alinkId']); 
                    $usuario->setStatus(UsuarioEntity::ACTIVE);
                    $em->remove($link);
                    $em->persist($usuario);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('notice', 'Usuario Activado con exito');
            }
        }else{
            $this->get('session')->getFlashBag()->add('notice', 'El link ha caducado');            
        }
      //  return $this->render('EtkUsuariosBundle:Default:activar.html.twig', array(  'data' => $dataquery[0])); 
       return $this->redirectToRoute('etk_usuarios_homepage');
        
    }
    
    /*
     *
     *       
     */
    public function cambiarPassAction(Request $request) {
        $usuarios = new UsuarioEntity();
        $form = $this->createForm(new \Etk\Bundle\UsuariosBundle\Form\UsuariosType(), 
                                  $usuarios, 
                                  Array('action'=>$this->generateUrl('etk_usuarios_nuevapassword'),
                                        'method'=>'POST')
                                  );
        $form->handleRequest($request);
        if ($request->isMethod('POST')) {
            if ($form->isValid()) {
                // guardar la tarea en la base de datos
                $usr= $this->get('security.context')->getToken()->getUser();
                $usuarios = $form->getData();
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($usuarios);
                $pasword = $encoder->encodePassword($usuarios->getPlainPassword(), $usuarios->getSalt());
                $usr->setPassword($pasword);
                $em = $this->getDoctrine()->getManager();
                $em->persist($usr);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Contraseña cambiada con Exito');
                return $this->redirectToRoute('etk_usuarios_homepage');
            }else{
                return $this->render('EtkUsuariosBundle:Default:cambiar_pass.html.twig', array(  'form' => $form->createView(),));
            }

        }else{
            return $this->render('EtkUsuariosBundle:Default:cambiar_pass.html.twig', array(  'form' => $form->createView(),));
        }         
        return $this->render('EtkUsuariosBundle:Default:cambiar_pass.html.twig', array(  'form' => $form->createView(),));
    }
    
    public function sendPasswordAction(Request $request){
        $usuarios = new UsuarioEntity();
        $form = $this->createForm(new \Etk\Bundle\UsuariosBundle\Form\UsuariosType(), 
                                  $usuarios, 
                                  Array('action'=>$this->generateUrl('etk_usuarios_sendPassword'),
                                        'method'=>'POST')
                                  );
        $form->handleRequest($request);
        if($form->isSubmitted()){
            //Se debe buscar el mail, generar un linkactivation con method=password y luego enviarle mail con el mismo
            $usuarios = $form->getData();
            $result = $this->get('etk_admin.usuarios')->getUserByMail($usuarios->getEmail());
            if ($result) {
                // generar un link po cada email
                foreach($result as $resultUser) 
                {
                    $em = $this->getDoctrine()->getManager();
                    $activationLink = new ActivationEntity();
                    $activationLink->setUserId($resultUser->getId());
                    $activationLink->setExpireDate( new \DateTime('tomorrow'));
                    $activationLink->setMethod( ActivationEntity::METHOD_PASSWORD);
                    $em->persist($activationLink);
                    $em->flush();
                    $this->get('etk_admin.usuarios')->sendRestorePasswordmail($resultUser,$activationLink->getId());                }
            }
            return $this->redirectToRoute('etk_usuarios_login');
        }
        return $this->render('EtkUsuariosBundle:Default:enviarPassword.html.twig', array(  'form' => $form->createView(),));
        
    }
    
    public function restorePasswordAction($userId){
        $providerKey = 'secured_area'; // your firewall name
        $usuario = $this->getDoctrine()->getRepository('EtkUsuariosBundle:Usuarios')->find($userId); 
        if($usuario == null) {
             throw new NotFoundHttpException('Sorry not existing!');
        }
        $token = new UsernamePasswordToken($usuario, null, $providerKey, $usuario->getRoles());

        $this->container->get('security.context')->setToken($token);
        return $this->redirectToRoute('etk_usuarios_nuevapassword');
    }
}
