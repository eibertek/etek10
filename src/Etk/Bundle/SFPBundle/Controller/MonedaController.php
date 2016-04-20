<?php

namespace Etk\Bundle\SFPBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Etk\Bundle\SFPBundle\Entity\moneda;
use Etk\Bundle\SFPBundle\Form\monedaType;

class MonedaController extends Controller
{
    public function altaAction(\Symfony\Component\HttpFoundation\Request $request)
    {
    $moneda = new moneda();
        
        $formAlta = $this->createForm(new monedaType(), $moneda,Array('action'=>$this->generateUrl('monedaAlta'),'method'=>'POST'));
        
        $formAlta->handleRequest($request);
 
        if ($formAlta->isValid()) {
            $from = new \DateTime($moneda->getSfpFecha());
            $moneda->setSfpFecha($from);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($moneda);
            $em->flush();

            $session = $this->getRequest()->getSession();
            $session->getFlashBag()->add('moneda', 'Moneda Guardada');

            return $this->redirectToRoute('monedaListar');// $this->render('EtkSFPBundle:Moneda:listar.html.twig', array());    
        }
        return $this->render('EtkSFPBundle:Moneda:alta.html.twig', array('formAlta' => $formAlta->createView()));    
                
  }

    public function bajaAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        if($request->get('id')!=null){
            $em = $this->getDoctrine()->getManager();
            $moneda = $em->find('EtkSFPBundle:moneda',$request->get('id'));
            $result = $em->remove($moneda);
            $em->flush();
            $session = $this->getRequest()->getSession();
            $session->getFlashBag()->add('moneda', 'Moneda Borrada con exito');
            if($request->isXmlHttpRequest()) {
                $response = new \Symfony\Component\HttpFoundation\Response();
                $output = array('success' => true, 'moneda' => $moneda->getSfpCaracter());
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($output));
                return $response;
            }
        }        
        return $this->render('EtkSFPBundle:Moneda:baja.html.twig', array(
                // ...
            ));    }

    public function listarAction()
    {
         $em = $this->getDoctrine()->getManager();
         $monedas = $em
            ->getRepository('EtkSFPBundle:moneda')
            ->findAll();
        return $this->render('EtkSFPBundle:Moneda:listar.html.twig', array(
            'monedas' => $monedas
            ));    }

}
