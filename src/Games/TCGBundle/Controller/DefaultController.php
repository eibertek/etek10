<?php

namespace Games\TCGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GamesTCGBundle:Default:index.html.twig');
    }
}
