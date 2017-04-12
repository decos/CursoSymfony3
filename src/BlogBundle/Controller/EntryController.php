<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use BlogBundle\Entity\Entry;
use BlogBundle\Form\EntryType;

class EntryController extends Controller
{
        private $session;

        public function __construct() {
            $this->session = new Session();
        }

        public function indexAction($page){
                
                $em  = $this->getDoctrine()->getEntityManager();
                $entry_repo = $em->getRepository("BlogBundle:Entry");
                //$entries = $entry_repo->findAll();
                $pageSize=5;
                $entries = $entry_repo->getPaginateEntries($pageSize, $page);
                
                $category_repo = $em->getRepository("BlogBundle:Category");
                $categories = $category_repo->findAll();
                
                //--Para mostrar los links y evitar el uso de la URL
                $totalItems = count($entries); //Total de elementos que vienen del paginador
                $pagesCount = ceil($totalItems/$pageSize);  //Redondear el calculo de total items
                
                return $this->render("BlogBundle:Entry:index.html.twig", array(
                                'entries' => $entries,
                                'categories' => $categories,
                                'totalItems' => $totalItems, 
                                'pagesCount' => $pagesCount,
                                "page" => $page,
                                "page_m" => $page
                        )
                );
                
                
        }
        
        public function addAction(Request $request){

                $entry  = new Entry();
                $form = $this->createForm(EntryType::class, $entry);

                $form->handleRequest($request);

                if($form->isSubmitted()){
                        if($form->isValid()){
                                
                                $em = $this->getDoctrine()->getEntityManager();
                                $category_repo = $em->getRepository("BlogBundle:Category");
                                //Llamar al Repositorio Entrada
                                $entry_repo = $em->getRepository("BlogBundle:Entry");
                                
                                $entry  = new Entry();
                                $entry->setTitle($form->get("title")->getData());
                                $entry->setStatus($form->get("status")->getData());
                                $entry->setContent($form->get("content")->getData());
                                
                                
                                //UPLOAD FILE
                                //Lo mismo: $form->get("image")->getData()
                                $file = $form["image"]->getData(); 
                                //obtener la extension
                                $ext = $file->guessExtension();
                                //asignar un nombre
                                $file_name = time(). "." . $ext;
                                //movemos a un directorio que se va llamar "uploads"
                                //ese directorio se coloca dentro del directorio web del framework
                                $file->move("uploads", $file_name);
                                //setear base de datos con el mismo nombre
                                $entry->setImage($file_name);
                                
                                
                                $category = $category_repo->find($form->get("category")->getData());
                                $entry->setCategory($category);
                                
                                //$user = $this->get("security.context")->getToken()->getUser();
                                $user = $this->getUser();
                                $entry->setUser($user);
                                
                                $em->persist($entry);
                                $flush = $em->flush();
                                
                                //Almacenar TAGS
                                $entry_repo->saveEntryTags(
                                        $form->get("tags")->getData(),
                                        $form->get("title")->getData(),
                                        $category,
                                        $user,
                                        $entry
                                );
                                
                                if($flush == null){
                                        $status = "La entrada se ha creado correctamente";
                                } else{
                                        $status = "Error al crear la entrada !!";
                                }
                                
                        } else {
                                $status = "La entrada no se ha creado porque el formulario no es válido";
                        }

                        $this->session->getFlashBag()->add("status", $status);
                        return $this->redirectToRoute("blog_homepage");
                } 

                return $this->render("BlogBundle:Entry:add.html.twig", array(
                                'form' => $form->createView()
                        )
                );
        }
       
        
        public function editAction(Request $request, $id){
                $em = $this->getDoctrine()->getEntityManager();
                $entry_repo = $em->getRepository("BlogBundle:Entry");
                $entry = $entry_repo->find($id);
                
                $category_repo = $em->getRepository("BlogBundle:Category");
                //$category = $category_repo->find($id);
                
                //OBTENER LOS TAGS DE LAS ENTRADAS
                $tags = "";
                foreach ($entry->getEntryTag() as $entryTag){
                        $tags.=$entryTag->getTag()->getName(). ",";
                }
                
                $form = $this->createForm(EntryType::class, $entry);
                //Bindear, Unir, los datos que viajen por POST al formulario
                $form->handleRequest($request);
                
                 if($form->isSubmitted()){
                        if($form->isValid()){
                                
                                $entry->setTitle($form->get("title")->getData());
                                $entry->setStatus($form->get("status")->getData());
                                $entry->setContent($form->get("content")->getData());
                                
                                //UPLOAD FILE
                                //Lo mismo: $form->get("image")->getData()
                                $file = $form["image"]->getData(); 
                                //obtener la extension
                                $ext = $file->guessExtension();
                                //asignar un nombre
                                $file_name = time(). "." . $ext;
                                //movemos a un directorio que se va llamar "uploads"
                                //ese directorio se coloca dentro del directorio web del framework
                                $file->move("uploads", $file_name);
                                //setear base de datos con el mismo nombre
                                $entry->setImage($file_name);
                                
                                
                                $category = $category_repo->find($form->get("category")->getData());
                                $entry->setCategory($category);
                                
                                //$user = $this->get("security.context")->getToken()->getUser();
                                $user = $this->getUser();
                                $entry->setUser($user);
                                
                                $em->persist($entry);
                                $flush = $em->flush();
                                
                                //Eliminar todas las relaciones entre ENTRADA y TAG
                                $entry_tag_repo = $em->getRepository("BlogBundle:EntryTag");
                                $entry_tags = $entry_tag_repo->findBy(array("entry" => $entry));
                                foreach ($entry_tags as $et){
                                        //if(is_object($et)){
                                        $em->remove($et);
                                        $em->flush();
                                        //}
                                }
                                
                                
                                //Almacenar TAGS
                                $entry_repo->saveEntryTags(
                                        $form->get("tags")->getData(),
                                        $form->get("title")->getData(),
                                        $category,
                                        $user,
                                        $entry
                                );
                                
                                if($flush == null){
                                        $status = "La entrada se ha editado correctamente";
                                } else{
                                        $status = "La entrada se ha editado mal";
                                }
                            
                        } else {
                                $status = "El formulario no es válido";
                        }
                        
                        $this->session->getFlashBag()->add("status", $status);
                        return $this->redirectToRoute("blog_homepage");
                        
                 }
                
                return $this->render("BlogBundle:Entry:edit.html.twig", array(
                                'form' => $form->createView(),
                                'entry' => $entry,
                                'tags' => $tags
                        )
                );
                
        }
        
        public function deleteAction($id){
            
                $em = $this->getDoctrine()->getEntityManager();
                $entry_repo = $em->getRepository("BlogBundle:Entry");
                $entry = $entry_repo->find($id);
                
                $entry_tag_repo = $em->getRepository("BlogBundle:EntryTag");
                $entry_tags = $entry_tag_repo->findBy(array("entry" => $entry));
                foreach ($entry_tags as $et){
                        //if(is_object($et)){
                        $em->remove($et);
                        $em->flush();
                        //}
                }
                //if(is_object($entry)){
                $em->remove($entry);
                $em->flush();
                //}
                return $this->redirectToRoute("blog_homepage");
                
        }
    
}
