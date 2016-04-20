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
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();        
        $recordSet = $em->getRepository("EtkSFPBundle:registro")->findBy(Array('sfpIdUsuario'=>$user->getId()));
        $registros = Array();
        $total = 0;
        $caracterMoneda = "$";
        foreach($recordSet as $rs)
        {
            $rsMoneda = $em->getRepository("EtkSFPBundle:moneda")->find($rs->getSfpMoneda());
            if($rs->getSfpTipo()=='-'){
                $total-=$rs->getSfpMonto();
            }else{
                $total+=$rs->getSfpMonto();
            }
            if($rsMoneda!=null){
                    $registro = Array();
                    $registro['id'] = $rs->getSfpIdRegistro();
                    $registro['fecha'] = $rs->getSfpFecha()->format('d/m/Y');
                    $registro['nombre'] = $rs->getSfpNombre();
                    $registro['tipo'] = $rs->getSfpTipo();
                    $registro['monto'] = $rsMoneda->getSfpCaracter();
                    $registro['monto'].= ' '.$rs->getSfpMonto();
                    $registro['descripcion'] = $rs->getSfpDescripcion();
                    $registros[] = $registro;
            }
        }
        return $this->render('EtkSFPBundle:registro:index.html.twig', array(
                "registros" => $registros, "total"=> $caracterMoneda.' '.$total
            )); 
    }

    public function altaAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $session = $this->getRequest()->getSession();
        $registro = new registro();
        
        $formAlta = $this->createForm(new registroType(), $registro,Array('action'=>$this->generateUrl('alta'),'method'=>'POST'));        
        $formAlta->handleRequest($request);
        //form_55bee17ee1846
        $token = $formAlta->getData()->getuniqueToken();
        $oldToken = $session->getFlashBag()->get('formtoken');
       //verificar que no coincidan los valores, porq ue esto tambien falla al tratar de dar un alta mas en este caso.
            if(isset($oldToken[0]) && $oldToken[0]==$token){
                           return $this->redirect( $this->generateUrl("index") );
            }
            
         
        if ($formAlta->isValid()) {
            $user = $this->getUser();
            $from = new \DateTime($registro->getSfpFecha());
            $registro->setSfpFecha($from);
            $registro->setSfpIdUsuario($user->getId());
            $em = $this->getDoctrine()->getManager();
            $em->persist($registro);
            $em->flush();

            $session->getFlashBag()->add('registro', 'Registro Guardado');
            $session->getFlashBag()->add('registroId', $registro->getSfpIdRegistro());
            $session->getFlashBag()->add('formtoken', $token);
            // Reseteo datos
            $registro = new registro();
            $formAlta = $this->createForm(new registroType(), $registro);        
            return  $this->render('EtkSFPBundle:registro:alta.html.twig', array('formAlta' => $formAlta->createView()));    
        }
        return $this->render('EtkSFPBundle:registro:alta.html.twig', array('formAlta' => $formAlta->createView()));    
        
    }
    
    public function borrarAction(\Symfony\Component\HttpFoundation\Request $request)
    {
     if($request->get('id')!=null){
            $em = $this->getDoctrine()->getManager();
            if($request->isXmlHttpRequest()) {
                $registro = $em->find('EtkSFPBundle:registro',$request->get('id'));
                $result = $em->remove($registro);
                $em->flush();
                $session = $this->getRequest()->getSession();
                $session->getFlashBag()->add('registro', 'Registro Borrado con exito');
                $response = new \Symfony\Component\HttpFoundation\Response();
                $output = array('success' => true);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($output));
                return $response;
            }
        }   
        //redirect
        return $this->render('EtkSFPBundle:registro:borrar.html.twig', array(
                // ...
            ));    }

    public function modificarAction()
    {
        return $this->render('EtkSFPBundle:registro:modificar.html.twig', array(
                // ...
            ));    }

}