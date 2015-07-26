<?php

namespace Etk\Bundle\SFPBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Etk\Bundle\SFPBundle\Entity\registro;
use Etk\Bundle\SFPBundle\Form\registroType;

class registroController extends Controller
{
    public function indexAction()
    {
    // aca poner la pantalla de mostrar - que muestres los registros 2
        $registros = Array();
        return $this->render('EtkSFPBundle:registro:index.html.twig', array(
                "registros" => $registros
            )); 
    }

    public function altaAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        
        $registro = new registro();
        
        $formAlta = $this->createForm(new registroType(), $registro);
        
        $formAlta->handleRequest($request);
 
        if ($formAlta->isValid()) {
            $from = new \DateTime($registro->getSfpFecha());
            $registro->setSfpFecha($from);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($registro);
            $em->flush();

            $session = $this->getRequest()->getSession();
            $session->getFlashBag()->add('registro', 'Registro Guardado');

            return  $this->render('EtkSFPBundle:registro:success.html.twig', array());    
        }
        return $this->render('EtkSFPBundle:registro:alta.html.twig', array('formAlta' => $formAlta->createView()));    
        
    }
    
    public function borrarAction()
    {
        return $this->render('EtkSFPBundle:registro:borrar.html.twig', array(
                // ...
            ));    }

    public function modificarAction()
    {
        return $this->render('EtkSFPBundle:registro:modificar.html.twig', array(
                // ...
            ));    }

}
