<?php

namespace Games\TCGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Games\TCGBundle\Entity\deck;
use Games\TCGBundle\Form\DeckType;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use Games\TCGBundle\Controller\AdminController;

class CardController extends AdminController{

    public function indexAction(Request $request)
    {
        $data = $this->get('games_tcg.deck')->getList();
        return $this->render('GamesTCGBundle:Deck:index.html.twig',Array(
                                                            'apiKey'=>$this->getApiKey(),
                                                            'data'=>$data));
    }
    
    public function newCardAction(Request $req){
        
    }
}
