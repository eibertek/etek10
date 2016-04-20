<?php

namespace Games\TCGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Debug\Debug;

class BoardController extends Controller
{
    public function indexAction()
    {
        Debug::enable();
        return $this->render('GamesTCGBundle:Board:index.html.twig');
    }
}
