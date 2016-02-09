<?php

namespace Etk\Bundle\AdminBundle\Controller;

use Doctrine\Common\Cache\ArrayCache;
use Etk\Bundle\NoticiasBundle\Entity\Noticias;
use Etk\Bundle\NoticiasBundle\Form\NoticiasType;
use Etk\Bundle\UsuariosBundle\Form\UsuariosType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Etk\Bundle\UsuariosBundle\Entity\Usuarios;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{
    
    private $api_Key;


    public function indexAction()
    {
        $users = $this->get('etk_admin.usuarios')->getList();
        $users = $this->get('etk_admin.usuarios')->serialize($users);
        $data = json_decode($users,true);
        return $this->render('EtkAdminBundle:Default:dashboard.html.twig',Array('data'=>$data));
    }

    
    public function preExecute()
    {
        $api_key = $this->container->getParameter( 'etk_api' )['api_key'];
        $this->api_Key = $this->get('sha256salted_encoder')->encodePassword($api_key, '45826189');

    }
    
    public function getApiKey()
    {
        return $this->api_Key;
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
        $form = $this->createForm(new UsuariosType(), $usuarios, Array('action'=>'','method'=>'POST')
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
                $em = $this->getDoctrine()->getManager();
                $em->persist($usuarios);
                $em->flush();
                return $this->render('EtkAdminBundle:default:success.html.twig', array(  'msg' => 'Se ha creado el usuario con exito', 'path' => 'etk_admin_users'));
            }else{
                return $this->render('EtkAdminBundle:users:newUser.html.twig', array(  'form' => $form->createView(),));
            }

        }else{
            return $this->render('EtkAdminBundle:users:newUser.html.twig', array(  'form' => $form->createView(),));
        }
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


}
