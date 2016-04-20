<?php

namespace Etk\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Etk\ApiBundle\Controller\DefaultController;

class UsuariosController extends DefaultController
{
    public function getUserAction($id)
    {
        if ( ! $this->validateApi_key() ) {
            return $this->error(self::INVALID_APIKEY);   
        }         
        $search = $this->getDoctrine()->getRepository('EtkUsuariosBundle:Usuarios')->find($id);
        if($search==null){
            return $this->error(self::INVALID_ID);
        }

        return $this->returnJson($search);
    }
    
   public function getUsersAction()
    {
        if ( ! $this->validateApi_key() ) {
            return $this->error(self::INVALID_APIKEY);   
        }        
        $search = $this->getDoctrine()->getRepository('EtkUsuariosBundle:Usuarios')->findAll();
        if($search==null){
            return $this->error(self::INVALID_SEARCH);
        }

        return $this->returnJson($search);

    }    

    public function deleteUserAction($id)
    {
        if ( ! $this->validateApi_key() ) {
            return $this->error(self::INVALID_APIKEY);   
        }         
        $search = $this->get('etk_admin.usuarios')->getUserAsArray($id);
        if($search==null){
            return $this->error(self::INVALID_ID);
        }
        $status = $this->get('etk_admin.usuarios')->deleteUser($id);
        $response = Array('action'=>'delete', 'id'=>$id, 'status'=>$status);
        return $this->returnJson($response);
    } 

    public function activateUserAction($id)
    {
        if ( ! $this->validateApi_key() ) {
            return $this->error(self::INVALID_APIKEY);   
        }         
        $search = $this->get('etk_admin.usuarios')->getUserAsArray($id);
        if($search==null){
            return $this->error(self::INVALID_ID);
        }
        $status = $this->get('etk_admin.usuarios')->activateUser($id);
        $response = Array('action'=>'activate', 'id'=>$id, 'status'=>$status);
        return $this->returnJson($response);
    } 
    
    public function banUserAction($id)
    {
        if ( ! $this->validateApi_key() ) {
            return $this->error(self::INVALID_APIKEY);   
        }         
        $search = $this->getDoctrine()->getRepository('EtkUsuariosBundle:Usuarios')->find($id);
        if($search==null){
            return $this->error(self::INVALID_ID);
        }
   
        return $this->returnJson($search);

    }    
}
