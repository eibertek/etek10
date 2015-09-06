<?php

namespace Etk\Bundle\SFPBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('EtkSFPBundle:Default:index.html.twig', array('name' => $name));
    }
}
