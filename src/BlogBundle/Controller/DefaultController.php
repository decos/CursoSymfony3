<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        //Ejemplo: Listar todas las entradas
        $em = $this->getDoctrine()->getManager();
        $entry_repo = $em->getRepository("BlogBundle:Category");
        
        
        return $this->render('BlogBundle:Default:index.html.twig');
    }
}
