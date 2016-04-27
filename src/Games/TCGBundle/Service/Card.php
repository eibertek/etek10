<?php

namespace Games\TCGBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Doctrine\ORM\Query;
use Games\TCGBundle\Entity\deck as DeckEntity;
use Games\TCGBundle\Service\service as games_service;

class Deck extends games_service
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
        $repository = $this->em->getRepository('GamesTCGBundle:card')
                           ->findAll();
        return $repository;
    }
    
    public function getCard($id)
    {
        $repository = $this->em->getRepository('GamesTCGBundle:card')
                           ->find($id);
        if(!$repository) return false;
        return $repository;        
    }

    public function registerCard($card)
    {
        $repository = $this->em->getRepository('GamesTCGBundle:card')
                           ->find($id);
        if(!$repository) return false;
        return $repository;        
    }
    
    public function getDeckByName($name)
    {
        $repository = $this->em->getRepository('GamesTCGBundle:deck')
                           ->findBy(Array('name'=>$name));
        if(!$repository) return false;
        return $repository;        
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
    
    public function modifyDeck($deckId, DeckEntity $deckEntity)
    {
        //get by id
        if($deckId != ""){
            $deck = $this->getDeck($deckId);
            if($deckEntity->getName()!=""){
                $deck->setName($deckEntity->getName());
            }
            $deck->setPremium($deckEntity->getPremium());
            $deck->setActive($deckEntity->getActive());
            $this->em->persist($deck);
            $this->em->flush($deck);            
            return true;
        }
        return false;
    }
    
    public function deleteDeck($deckId)
    {
        //get by id
        if($deckId != ""){
            try {
                $deck = $this->getDeck($deckId);
                if($deck){
                    $this->em->remove($deck);
                    $this->em->flush($deck);                            
                }else{
                    throw new \Exception('Bad Id');
                }
            } catch (\Exception $ex) {
                return false;
            }
            return true;
        }
        return false;
    }
    
    
    public function getUUID()
    {
        
        $stmt = $this->em->getConnection()->prepare( "SELECT uuid();" );
        $stmt->execute();
        return $stmt->fetchAll();
    }      
}