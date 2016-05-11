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
 
    public function generateDeckAction() {
        $response = Array();
        for($i=1; $i<11; $i++){
            for($j=1;$j<3;$j++){
            $letter = chr($j+64);    
            $deck = Array("name"=>"Card #$i $letter", 
                          "attack"=>$i*1000, 
                          "defense"=>$i*1000,
                          "life"=>$i*10000,
                          "cardId"=>  uniqid(),
                          "status"=> null,
                          "playerId"=> null
                          );
            $response[] = $deck;
            }
        }
        return $this->returnJson($response);
    }    
}
