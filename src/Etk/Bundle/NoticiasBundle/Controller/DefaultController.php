<?php

namespace Etk\Bundle\NoticiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
      $user = $this->container->get('security.context')->getToken()->getUser();
      return $this->render('EtkNoticiasBundle:Default:index.html.twig');
    }


    public function contactAction()
    {
        return $this->render('EtkNoticiasBundle:Default:contacto.html.twig');
    }
}
