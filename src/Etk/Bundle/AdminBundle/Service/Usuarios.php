<?php

namespace Etk\Bundle\AdminBundle\Service;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class Usuarios
{
  protected $em;

  public function __construct(\Doctrine\ORM\EntityManager $em)
  {
    $this->em = $em;
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
    
    public function banUser($id)
    {
        
    }
    
    public function serialize($data, $format='json'){
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->serialize($data, $format);

    }    
}