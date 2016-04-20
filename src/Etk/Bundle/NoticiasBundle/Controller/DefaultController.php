<?php

namespace Etk\Bundle\NoticiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Etk\Bundle\NoticiasBundle\Entity\Noticias;

class DefaultController extends Controller
{
    public function indexAction()
    {
       $allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
        $allowedTags.='<li><ol><ul><span><div><br><ins><del>';  
       // Should use some proper HTML filtering here.
         if(isset($_POST['mytextarea']) && $_POST['mytextarea']!='') {
           $sHeader = '<h1>Ah, content is king.</h1>';
           $sContent = strip_tags(stripslashes($_POST['mytextarea']),$allowedTags);
       } else {
           $sHeader = '<h1>Nothing submitted yet</h1>';
           $sContent = '<p>Start typing...</p>';
           $sContent.= '<p><img width="107" height="108" border="0" src="/mediawiki/images/badge.png"';
           $sContent.= 'alt="TinyMCE button"/>This rover has crossed over</p>';
         }

      return $this->render('EtkNoticiasBundle:Default:index.html.twig', Array('sHeader'=>$sHeader, 'sContent'=>$sContent));
    }


    public function contactAction()
    {
        return $this->render('EtkNoticiasBundle:Default:contacto.html.twig');
    }
    
    public function parallax1Action()
    {
        $noticia = new Noticias();
        $noticia->setFecha(new \DateTime('12/03/2015'));
        $noticia->setTitulo('Nuevo sistema de Finanzas');
        $noticia->setSubtitulo('');
        $noticia->setCuerpo("Estamos trabajando con una nueva aplicación para los usuarios, en este momento está la versión <i>Alpha 0.1</i>.");
        $noticias[] = $noticia;

        $noticia = new Noticias();
        $noticia->setFecha(new \DateTime('10/03/2015'));
        $noticia->setTitulo('Rediseño del Sitio');
        $noticia->setSubtitulo('');
        $noticia->setCuerpo("Se ha rediseñado el sitio para una mejor lectura");
        $noticias[] = $noticia;

        $noticia = new Noticias();
        $noticia->setFecha(new \DateTime('01/03/2015'));
        $noticia->setTitulo('Mejoras en el sistema');
        $noticia->setSubtitulo('');
        $noticia->setCuerpo("Se ha rediseñado el sistema de usuarios, incluida la opción de reestablecer Password");
        $noticias[] = $noticia;

        return $this->render('EtkNoticiasBundle:Default:parallax1.html.twig', Array('noticias'=>$noticias) );
    }    

    public function staticPageAction($page)
    {
        $title="Eibertek";
        if($page === "dbzTcg") $title = "DBZ Trading Card Game";
        if($page == '') $page = "Partials/noticias"; 
        $staticPage = "EtkNoticiasBundle:Default:$page.html.twig";
        return $this->render('EtkNoticiasBundle:Default:primaryContent.html.twig',Array('staticPage'=>$staticPage, 'titulo'=>$title));
    }     
}
