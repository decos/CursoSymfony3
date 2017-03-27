<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    // RELACIONES MUCHOS A MUCHOS
    public function indexAction()
    {
        //Ejemplo: Listar todas las entradas
        //$em = $this->getDoctrine()->getManager();
        $em =  $this->getDoctrine()->getEntityManager();
        $entry_repo = $em->getRepository("BlogBundle:Entry");
        $entries = $entry_repo->findAll();
        
        foreach($entries as $entry){
            echo $entry->getTitle() . "<br/>";
            echo $entry->getCategory()->getName() . "<br/>";
            echo $entry->getUser()->getName() . "<br/>";
            
            //RELACION UNO A MUCHOS
            $tags = $entry->getEntryTag();
            foreach($tags as $tag){
                echo $tag->getTag()->getName() . ",  ";
            }
            
            echo "<hr/>";
        }
        
        die();
        
        return $this->render('BlogBundle:Default:index.html.twig');
    }
}
