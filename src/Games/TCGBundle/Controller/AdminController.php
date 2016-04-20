<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Games\TCGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Debug\Debug;
use Games\TCGBundle\Entity\card;

class AdminController extends Controller
{
    
    private $api_Key;

    public function preExecute()
    {
        $api_key = $this->container->getParameter( 'etk_api' )['api_key'];
        $this->api_Key = $this->get('sha256salted_encoder')->encodePassword($api_key, '45826189');

    }
    
    public function getApiKey()
    {
        return $this->api_Key;
    }
        
    public function indexAction()
    {
        $securityContext = $this->container->get('security.token_storage');
        return $this->render('GamesTCGBundle:Admin:index.html.twig');
    }
    
    public function mockCardAction()
    {
        $image = 'aaaaaaaaaaaa';file_get_contents('http://www.4geekslikeyou.com/wp-content/uploads/2014/02/goku_by_maffo1989-d4vxux4.png');
        $securityContext = $this->container->get('security.token_storage');
        $card = new card();
        $card->setAttack(2000);
        $card->setDefense(2000);
        $card->setDescription('Carta de Prueba');
        $card->setEnergy(4);
        $card->setLife(10000);
        $card->setTitle('Carta Suprema');
        $card->setSubtitle('Esta cartas es de prueba');
        $card->setLeyend('Probando la carta');
        $card->setImage($image);
        $em = $this->getDoctrine()->getManager();
        $em->persist($card);
        $cardObject = $card;
        $em->flush($card);
        $image = base64_encode($image);
        return $this->render('GamesTCGBundle:Admin:mockCard.html.twig', Array('img'=>$image ,'card' => $cardObject));
    }

/** Crear nuevo Mazo */
/** Crear nueva Carta */
/** Crear Nueva regla */
    
}
