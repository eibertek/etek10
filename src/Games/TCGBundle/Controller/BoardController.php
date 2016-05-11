<?php

namespace Games\TCGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;


class BoardController extends AdminController
{
    public function indexAction(Request $rq)
    {
        Debug::enable();
        return $this->render('GamesTCGBundle:Board:index.html.twig',Array('api_key'=>$this->getApiKey()));
    }
    

}
