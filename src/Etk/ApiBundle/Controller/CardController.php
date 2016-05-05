<?php

namespace Etk\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Etk\ApiBundle\Controller\DefaultController;

class DeckController extends DefaultController
{
    public function deleteDeckAction($deckId)
    {
        if ( ! $this->validateApi_key() ) {
            return $this->error(self::INVALID_APIKEY);   
        } 
        $execute = $this->get('games_tcg.deck')->deleteDeck($deckId);
        if($execute){
            $status='OK';
        }else{
            $status='FAIL';
        }
        $response = Array('action'=>'delete', 'id'=>$deckId, 'status'=>$status);
        return $this->returnJson($response);
    } 
 
}
