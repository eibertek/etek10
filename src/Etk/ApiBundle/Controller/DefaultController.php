<?php

namespace Etk\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class DefaultController extends Controller
{
    
    const INVALID_ID = 9432;
    const INVALID_APIKEY = 9433;
    const INVALID_SEARCH = 9434;
    
    
    public function indexAction()
    {
        return $this->render('EtkApiBundle:Default:index.html.twig');
    }
    
    public function preExecute() {
            if ( ! $this->validateApi_key() ) return $this->error(self::INVALID_APIKEY);    
            
    }    
    
    protected function validateApi_key()
    {
        //481f96a38a01eaf230eb8cb60ed868fd0c08f9a1ed514101283f20b8d4fc6ad0
        if(!isset(getallheaders()['Authorization'])) throw $this->createAccessDeniedException ();
        $apikey = getallheaders()['Authorization'];
        $api_key = $this->container->getParameter( 'etk_api' )['api_key'];
        $expression = $this->get('sha256salted_encoder')->encodePassword($api_key, '45826189');
        if($expression === $apikey) return true;
        return false;
    }
    
    protected function error($error)
    {
       if($error == self::INVALID_APIKEY) 
            return $this->returnJson(Array('error'=>'invalid Api Key'));
       if($error == self::INVALID_ID) 
            return $this->returnJson(Array('error'=>'invalid Id'));
       
    }    
    
    protected function returnJson(Array $result)
    {
        $response = new Response($this->serialize($result));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }    

    public function serialize($data, $format='json'){
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->serialize($data, $format);

    }     
}
