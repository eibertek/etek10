<?php

namespace Etk\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Etk\ApiBundle\Controller\DefaultController;

class UsuariosController extends DefaultController
{
    public function getUserAction($id)
    {
        $search = $this->getDoctrine()->getRepository('EtkUsuariosBundle:Usuarios')->find($id);
        if($search==null){
            return $this->error(self::INVALID_ID);
        }
      /*  $result = Array(
                    "nombre" =>$search->getNombre(),
                    "apellido" =>$search->getApellido(),
                    "id" =>$search->getId(),
                    "status" =>$search->getStatus(),
                        );
       */
        return $this->returnJson($search);
//        return $this->render('EtkApiBundle:Default:index.html.twig');
//         throw new BadRequestHttpException("You must pass username and password fields");
    }
    
   public function getUsersAction()
    {
         $search = $this->getDoctrine()->getRepository('EtkUsuariosBundle:Usuarios')->findAll();
        if($search==null){
            return $this->error(self::INVALID_SEARCH);
        }
      /*  foreach ( $search as $usuarios)
        {
            $result[] = Array(
                "nombre" =>$usuarios->getNombre(),
                "apellido" =>$usuarios->getApellido(),
                "id" =>$usuarios->getId(),
                "status" =>$usuarios->getStatus(),
                    );        
        }
       */
        return $this->returnJson($search);
//        return $this->render('EtkApiBundle:Default:index.html.twig');
//         throw new BadRequestHttpException("You must pass username and password fields");
    }    

   
}
