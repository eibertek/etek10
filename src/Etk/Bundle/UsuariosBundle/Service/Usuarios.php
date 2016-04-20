<?php

namespace Etk\Bundle\UsuariosBundle\Service;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Doctrine\ORM\Query;
use Etk\Bundle\UsuariosBundle\Entity\Usuarios as UsuarioEntity;

class Usuarios
{
  protected $em;
  protected $twig;
  protected $mailer;

  
  public function __construct(\Doctrine\ORM\EntityManager $em, \Symfony\Bundle\TwigBundle\TwigEngine $twig, \Swift_Mailer $mailer)
  {
    $this->em = $em;
    $this->twig = $twig;
    $this->mailer = $mailer;
  }
  
    public function getList()
    {

        $repository = $this->em->getRepository('EtkUsuariosBundle:Usuarios')
                           ->findAll();
        return $repository;

    }
    
    public function getUser($id)
    {
        $repository = $this->em->getRepository('EtkUsuariosBundle:Usuarios')
                           ->find($id);
        if(!$repository) return false;
        return $repository;        
    }

    public function getUserByMail($email)
    {
        $repository = $this->em->getRepository('EtkUsuariosBundle:Usuarios')
                           ->findBy(Array('email'=>$email));
        if(!$repository) return false;
        return $repository;        
    }
    
    public function banUser($id)
    {
        
    }
    
    public function serialize($data, $format='json'){
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->serialize($data, $format);

    }    

    public function sendmail($usuarios, $activationLinkId){
        $message = \Swift_Message::newInstance()
        ->setSubject('Bienvenido a Eibertek!')
        ->setFrom('altas@eibertek.com')
        ->setTo($usuarios->getEmail())
        ->setBody(
              $this->twig->render(
                'EtkUsuariosBundle:messages:AltaEmail.html.twig',
                array('usuario' => $usuarios, 'link' => $activationLinkId)
            ),
            'text/html'
        );
        $this->mailer->send($message);
    }

    public function sendRestorePasswordmail($usuarios, $activationLinkId){
        $message = \Swift_Message::newInstance()
        ->setSubject('Cambiar Contraseña Usuario '. $usuarios->getUserName().' De pagina Eibertek')
        ->setFrom('administracion@eibertek.com')
        ->setTo($usuarios->getEmail())
        ->setBody(
              $this->twig->render(
                'EtkUsuariosBundle:messages:PasswordEmail.html.twig',
                array('usuario' => $usuarios, 'link' => $activationLinkId)
            ),
            'text/html'
        );
        $this->mailer->send($message);
    }
    
    public function validate($usuarios){
        $search = $this->em->getRepository('EtkUsuariosBundle:Usuarios');
        $criteria = (array('email' => $usuarios->getEmail(), 'username'=>$usuarios->getUsername()));
        $users = $search->findBy($criteria);
        if(count($users)>=1){
            return false;
        }else{
            return true;
        }
    }   
    
    public function deleteUser($id)
    {
        $repository = $this->em->getRepository('EtkUsuariosBundle:Usuarios')
                           ->find($id);
        $status = $this->em->remove($repository);
        $this->em->flush();
        return 'OK';

    }

    public function activateUser($id)
    {
        $repository = $this->em->getRepository('EtkUsuariosBundle:Usuarios')
                           ->find($id);
        $repository->setStatus(UsuarioEntity::ACTIVE);  
        $query = $this->em->createQuery('
            SELECT u.username, u.nombre, u.id as userId,  u.apellido, u.status , a.expireDate, a.id as alinkId 
            FROM EtkUsuariosBundle:Usuarios u
            inner join EtkUsuariosBundle:Activationlink a
            with u.id = a.userId 
            WHERE u.id = :id
        ');
        $query->setParameter('id', $id);
        $dataquery = $query->getResult();
        $link = $this->em->getRepository('EtkUsuariosBundle:Activationlink')->find($dataquery[0]['alinkId']); 
        if ( $link ){
            $this->em->remove($link);
        }
        $this->em->persist($repository);
        $this->em->flush();        
        return 'OK';
/*
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
       */ 
    }
    
    public function getUserAsArray($id)
    {
        $query = $this->em->createQuery("SELECT u FROM EtkUsuariosBundle:Usuarios u where u.id = ?1");
        $query->setParameter(1, $id);
        $repository = $query->getResult(Query::HYDRATE_ARRAY);
        if(!$repository) return false;
        return $repository;        
    }    
    
    public function getUUID()
    {
        
        $stmt = $this->em->getConnection()->prepare( "SELECT uuid();" );
        $stmt->execute();
        return $stmt->fetchAll();
    }      
}