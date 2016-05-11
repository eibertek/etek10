<?php

namespace Games\TCGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Games\TCGBundle\Entity\card;
use Games\TCGBundle\Form\CardType;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use Games\TCGBundle\Controller\AdminController;
//use Etk\Bundle\AdminBundle\Service\FiltersTwigExtension as FilterExtension;

class CardController extends AdminController{

    public function indexAction(Request $request)
    {
        //$request->setLocale('es');
        $data = $this->get('games_tcg.card')->getList();
        return $this->render('GamesTCGBundle:Card:index.html.twig',Array(
                                                            'apiKey'=>$this->getApiKey(),
                                                            'data'=>$data));
    }

    public function newCardAction(Request $request)
    {
        //INIT valores
        $cardEntity = new card();
        $form = $this->createForm(new CardType(), $cardEntity, Array('action'=>'','method'=>'POST'));
        //SI no hay post, muestro el formulario
        $lastId=$this->get('session')->getFlashBag()->get('lastId');
        if( isset($lastId[0])  )
        {
           return  $this->redirectToRoute('games_tcg_CardIndex');
        }
        $form->handleRequest($request);        
        if ($request->isMethod('POST')) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($cardEntity);
                //$this->get('session')->getFlashBag()->add('lastId', $deckEntity->getDeckId());
                $em->flush($cardEntity);
                unset($_POST);
                $this->get('session')->getFlashBag()->add('info', 'Carta creada!');
                return $this->redirectToRoute('games_tcg_CardIndex');
            }
        }
//        return $this->render('GamesTCGBundle:Deck:newDeck.html.twig',Array('deckForm'=>$form->createView()));
        return $this->render('GamesTCGBundle:Card:newCard.html.twig',Array(
                                                            'apiKey'=>$this->getApiKey(),
                                                            'cardForm'=>$form->createView()));
    }

    public function modifyAction(Request $request)
    {
        $data = $this->get('games_tcg.deck')->getList();
        return $this->render('GamesTCGBundle:Deck:index.html.twig',Array(
                                                            'apiKey'=>$this->getApiKey(),
                                                            'data'=>$data));
    }
}
