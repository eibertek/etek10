<?php

namespace Etk\Bundle\AdminBundle\Service;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class Noticias
{
  protected $em;

  public function __construct(\Doctrine\ORM\EntityManager $em)
  {
    $this->em = $em;
  }
  
    public function getList()
    {

        $repository = $this->em->getRepository('EtkNoticiasBundle:Noticias')
                           ->findAll();
        if($repository && count($repository)>0){
            return $repository;
        }else{
            return false;            
        }
    }
    
    public function getNoticia($id)
    {
        $repository = $this->em->getRepository('EtkNoticiasBundle:Noticias')
                           ->find($id);
        if(!$repository) return false;
        return $repository;        
    }
    
    public function getComentario($idNoticia)
    {
        $repository = $this->em->getRepository('EtkNoticiasBundle:NoticiasComentario')
                           ->find($id);
        if(!$repository) return false;
        return $repository;         
    }
    
    public function serialize($data, $format='json'){
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->serialize($data, $format);

    }    
}