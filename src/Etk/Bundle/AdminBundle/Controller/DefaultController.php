<?php

namespace Etk\Bundle\AdminBundle\Controller;

use Doctrine\Common\Cache\ArrayCache;
use Etk\Bundle\NoticiasBundle\Entity\Noticias;
use Etk\Bundle\NoticiasBundle\Form\NoticiasType;
use Etk\Bundle\AdminBundle\Form\UsuariosType as usuariosAdmin;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Etk\Bundle\UsuariosBundle\Entity\Usuarios;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\SecurityContext;
use Etk\Bundle\UsuariosBundle\Entity\Activationlink as ActivationEntity;

class DefaultController extends Controller
{
    
    private $api_Key;

    public function preExecute()
    {
        $api_key = $this->container->getParameter( 'etk_api' )['api_key'];
        $this->api_Key = $this->get('sha256salted_encoder')->encodePassword($api_key, '45826189');

    }
    
    public function getApiKey()
    {
        return $this->api_Key;
    }
    
    public function indexAction()
    {
        $users = $this->get('etk_admin.usuarios')->getList();
        $noticias = $this->get('etk_admin.noticias')->getList();
        
        $users = $this->get('etk_admin.usuarios')->serialize($users);
        $noticias = $this->get('etk_admin.noticias')->serialize($noticias);
        $userData = json_decode($users,true);
        $noticiasData = json_decode($noticias,true);
        return $this->render(
                        'EtkAdminBundle:Default:dashboard.html.twig',
                        Array(
                            'userData'=>$userData, 
                            'noticiasData'=>$noticiasData, 
                            'api_key'=>$this->getApiKey()
                            )
                );
    }

    public function getFormAction($form, $type,$id="")
    {
        $em = $this->getDoctrine()->getManager();
        $activar=false;
        $banear = false;        
        if($form=='users'){
            if($type==='edit' && $id!==''){
                $usuarios = $em->find('EtkUsuariosBundle:Usuarios',$id);
                if($usuarios->getStatus() !== Usuarios::ACTIVE){
                    $activar=true;
                }else{
                    $banear = true;
                }
            }else{
                $usuarios = new Usuarios();
            }
            $form2 = $this->createForm(new usuariosAdmin(), 
                                      $usuarios, 
                                      Array('action'=>'','method'=>'POST','activar'=>$activar, 'banear'=>$banear)
                                      );        
            $dataInfo = $usuarios;
        }
        if($form=='noticias'){
            $noticias = new Noticias();
            $form2 = $this->createForm(new NoticiasType(), 
                                      $noticias, 
                                      Array('action'=>'','method'=>'POST')
                                      );        
            $dataInfo = $noticias;
        }        
        return $this->render('EtkAdminBundle:'.$form.':form_'.$type.'.html.twig', 
                             array(  'form' => $form2->createView(),'data' => $dataInfo, 'api_key'=>$this->getApiKey() ));
    }
    
    
    
    public function usersAction($name='admin')
    {
        $repository = $this->getDoctrine()
            ->getRepository('EtkUsuariosBundle:Usuarios')
            ->findAll();

        return $this->render('EtkAdminBundle:users:users.html.twig', array('users' => $repository));
    }

    public function noticiasAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('EtkNoticiasBundle:Noticias')
            ->findAll();

        return $this->render('EtkAdminBundle:noticias:noticias.html.twig', array('noticias' => $repository));
    }

    public function newUserAction(Request $request)
    {

        $usuarios = new Usuarios();
        $form = $this->createForm(new usuariosAdmin(), $usuarios, Array('action'=>'','method'=>'POST'));
        if(!$request->isXmlHttpRequest()) {
                $response = new Response();
                $response->setStatusCode(500);
                return $response;
        };
        $response = new Response();        
        $response->headers->set('Content-Type', 'application/json');
        $form->handleRequest($request);        
        if ($request->isMethod('POST')) {
            if ($form->isValid()) {
                // guardar la tarea en la base de datos
                $usuarios = $form->getData();
                if (!$this->get('etk_admin.usuarios')->validate($usuarios)) {
                    $this->get('session')->getFlashBag()->add('error', 'El Usuario que intenta crear ya está registrado, si no recuerda su contraseña vaya al login y haga click en recuperar contraseña');
                    return $this->render('EtkAdminBundle:users:form_new.html.twig', 
                                        array(  'form' => $form->createView()));             
                }                
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($usuarios);
                $pasword = $encoder->encodePassword($usuarios->getPlainPassword(), $usuarios->getSalt());
                $usuarios->setPassword($pasword);
                $usuarios->setCreateddate(new \DateTime("now"));
                $usuarios->setRole('ROLE_USER');
                $em = $this->getDoctrine()->getManager();                
                if($form['activate']->getData()){
                    $usuarios->setStatus(Usuarios::ACTIVE);  
                    $em->persist($usuarios);
                    $em->flush();                    
                }else{
                    $usuarios->setStatus(Usuarios::NOT_VALIDATED);   
                    $em->persist($usuarios);
                    $em->flush();                    
                    $activationLink = new ActivationEntity();
                    $activationLink->setUserId($usuarios->getId());
                    $activationLink->setExpireDate( new \DateTime('tomorrow'));
                    $em->persist($activationLink);
                    $em->flush();
                    $this->get('etk_admin.usuarios')->sendmail($usuarios,$activationLink->getId());                    
                }
                $output = array('success' => true, 'usuario'=>$usuarios);
                $response->setContent(json_encode($output));
                return $response;
            }else{
                    return $this->render('EtkAdminBundle:users:form_new.html.twig', 
                             array(  'form' => $form->createView()));                
              //  return $this->render('EtkAdminBundle:users:newUser.html.twig', array(  'form' => $form->createView(),));
            }
        }else{
                return $this->render('EtkAdminBundle:default:success.html.twig', array(  'msg' => 'Errores', 'path' => 'etk_admin_users'));
        }
        $response = new Response();
        $response->setStatusCode(401);
        return $response;        
    }

    public function newNoticiaAction(Request $request)
    {

        $noticias = new Noticias();
        $form = $this->createForm(new NoticiasType(), $noticias, Array('action'=>'','method'=>'POST')
        );

        $form->handleRequest($request);
        if ($request->isMethod('POST')) {
            if ($form->isValid()) {
                // guardar la tarea en la base de datos
                $noticias = $form->getData();
                $noticias->setCreateddate(new \DateTime("now"));
                $noticias->setFecha(new \DateTime($noticias->getFecha()));
                $em = $this->getDoctrine()->getManager();
                $em->persist($noticias);
                $em->flush();
                return $this->render('EtkAdminBundle:default:success.html.twig', array(  'msg' => 'Se ha creado la noticia con exito', 'path' => 'etk_admin_noticias'));
            }else{
                return $this->render('EtkAdminBundle:noticias:newNoticias.html.twig', array(  'form' => $form->createView(),));
            }

        }else{
            return $this->render('EtkAdminBundle:noticias:newNoticias.html.twig', array(  'form' => $form->createView(),));
        }
    }

    public function borrarNoticiaAction(Request $request){
        if($request->get('id')!=null){
            $entity  = new Noticias();
            $em = $this->getDoctrine()->getManager();
            $noticia = $em->find('EtkNoticiasBundle:Noticias',$request->get('id'));
            $result = $em->remove($noticia);
            $em->flush();
            if($request->isXmlHttpRequest()) {
                $response = new Response();
                $output = array('success' => true, 'noticia' => $noticia->getNombre(), 'Usuario' => $noticia->getUserId()->getUserName());
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($output));
                return $response;
            }
        }
        return $this->render('EtkAdminBundle:noticias:borrarnoticia.html.twig', array(  'noticia' => $noticia,));
    }

    public function logoutAction()
    {
        // The security layer will intercept this request

    }

    public function loginAction(Request $request)
    {
        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
       /*     return $this->redirect(
                $this->generateUrl("etk_admin_homepage")
            );*/
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
        return $this->render('EtkAdminBundle:Default:login.html.twig', $result);
    }

    public function securityCheckAction()
    {
        // The security layer will intercept this request

    }

    
    /**
    * List all errors of a given bound form.
    *
    * @param Form $form
    *
    * @return array
    */
   protected function getFormErrors($form)
   {
        $local_errors = array();
        foreach($form->getIterator() as $field=>$value){
            foreach($value->getErrors(true,true) as $key2 => $value2)
                {
                     $local_errors[$value->getName()]['name']    = $value->getName();
                     $local_errors[$value->getName()]['message'] = $value2->getMessage();                
                }

        }
       
        return $local_errors;

   }

}
