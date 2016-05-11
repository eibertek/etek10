<?php

namespace Etk\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Etk\ApiBundle\Controller\DefaultController;

class CardController extends DefaultController
{
    public function deleteCardAction($cardId)
    {
        if ( ! $this->validateApi_key() ) {
            return $this->error(self::INVALID_APIKEY);   
        } 
        $execute = $this->get('games_tcg.card')->deleteCard($cardId);
        if($execute){
            $status='OK';
        }else{
            $status='FAIL';
        }
        $response = Array('action'=>'delete', 'id'=>$cardId, 'status'=>$status);
        return $this->returnJson($response);
    } 
 
}
