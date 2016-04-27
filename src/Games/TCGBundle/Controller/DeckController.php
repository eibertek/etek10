<?php

namespace Games\TCGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Games\TCGBundle\Entity\deck;
use Games\TCGBundle\Form\DeckType;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use Games\TCGBundle\Controller\AdminController;

class DeckController extends AdminController
{
    public function indexAction(Request $request)
    {
        $deckId = $request->get('deckid');
        $data = Array();
        if(isset($deckId)){
            $deck = $this->get('games_tcg.deck')->getDeck($deckId);
            $data[] = $deck;
        }else{
            $data = $this->get('games_tcg.deck')->getList();
        }
        return $this->render('GamesTCGBundle:Deck:index.html.twig',Array(
                                                                    'apiKey'=>$this->getApiKey(),
                                                                    'data'=>$data));
    }
    
    /*
     * Generate a new Deck 
     */
    public function newDeckAction(Request $request){
        //INIT valores
        $deckEntity = new deck();
        $form = $this->createForm(new DeckType(), $deckEntity, Array('action'=>'','method'=>'POST'));
        //SI no hay post, muestro el formulario
        $lastId=$this->get('session')->getFlashBag()->get('lastId');
        if( isset($lastId[0])  )
        {
           return  $this->redirectToRoute('games_tcg_indexDeck');
        }
        $form->handleRequest($request);        
        if ($request->isMethod('POST')) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($deckEntity);
                $this->get('session')->getFlashBag()->add('lastId', $deckEntity->getDeckId());
                $em->flush($deckEntity);
                unset($_POST);
                $this->get('session')->getFlashBag()->add('info', 'Mazo creado!');
                return $this->redirectToRoute('games_tcg_indexDeck');
            }
        }
        return $this->render('GamesTCGBundle:Deck:newDeck.html.twig',Array('deckForm'=>$form->createView()));
    }
    
    /*
     * 
     */
    public function modifyDeckAction(Request $req){    
       $deckId = $req->get('deckid');
        $deckEntity = $this->get('games_tcg.deck')->getDeck($deckId);
        if($deckEntity === false){
            return $this->redirectToRoute('games_tcg_indexDeck');            
        }
        $form = $this->createForm(new DeckType(), $deckEntity, Array('action'=>'','method'=>'POST'));
        $form->handleRequest($req);        
        if ($req->isMethod('POST')) {
            if ($form->isValid()) {
                if($this->get('games_tcg.deck')->modifyDeck($deckId, $deckEntity)){
                    unset($_POST);
                    $this->get('session')->getFlashBag()->add('info', 'Se ha modificado el Mazo '. $deckEntity->getName());
                    return $this->redirectToRoute('games_tcg_indexDeck');                    
                }
            }
        }        
        return $this->render('GamesTCGBundle:Deck:modifyDeck.html.twig',Array('deckForm'=>$form->createView()));
    }
    
    /*
     * 
     */
    public function deleteDeckAction(){
        return $this->render('GamesTCGBundle:Deck:deleteDeck.html.twig',
                             Array(
                                 'apiKey'=>$this->getApiKey()
                                  )
                            );
    }    

    /*
     * 
     */
    public function enableDeckAction(){
        return $this->render('GamesTCGBundle:Deck:index.html.twig');
    }        

    /*
     * 
     */
    public function disableDeckAction(){
        return $this->render('GamesTCGBundle:Deck:index.html.twig');
    }        

    /*
     * 
     */
    public function addCardToDeckAction(){}            

    /*
     * 
     */
    public function removeCardToDeckAction(){}                
    
}
