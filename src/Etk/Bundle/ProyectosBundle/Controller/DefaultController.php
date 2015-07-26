<?php

namespace Etk\Bundle\ProyectosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('EtkProyectosBundle:Default:index.html.twig', array('name' => $name));
    }
}
