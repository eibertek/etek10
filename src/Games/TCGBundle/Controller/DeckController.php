<?php

namespace Games\TCGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Games\TCGBundle\Entity\deck;
use Games\TCGBundle\Form\DeckType;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

class DeckController extends Controller
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
        return $this->render('GamesTCGBundle:Deck:index.html.twig',Array('data'=>$data));
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
            $this->redirectToRoute('games_tcg_indexDeck');
        }
        $form->handleRequest($request);        
        if ($request->isMethod('POST')) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($deckEntity);
                $this->get('session')->getFlashBag()->add('lastId', $deckEntity->getDeckId());
                $em->flush($deckEntity);
                unset($_POST);
            }
        }
        return $this->render('GamesTCGBundle:Deck:newDeck.html.twig',Array('deckForm'=>$form->createView()));
    }
    
    /*
     * 
     */
    public function modifyDeckAction(){    
        return $this->render('GamesTCGBundle:Deck:modifyDeck.html.twig');
    }
    
    /*
     * 
     */
    public function deleteDeckAction(){
        return $this->render('GamesTCGBundle:Deck:deleteDeck.html.twig');
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
