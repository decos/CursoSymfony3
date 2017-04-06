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

        public function indexAction(){
                /*
                $em  = $this->getDoctrine()->getEntityManager();
                $category_repo = $em->getRepository("BlogBundle:Category");
                $categories = $category_repo->findAll();
            
                return $this->render("BlogBundle:Category:index.html.twig", array(
                                'categories' => $categories
                        )
                );*/
                
        }
        
        public function addAction(Request $request){

                $entry  = new Entry();
                $form = $this->createForm(EntryType::class, $entry);

                $form->handleRequest($request);

                if($form->isSubmitted()){
                        if($form->isValid()){
                                
                                $em = $this->getDoctrine()->getEntityManager();
                                
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
                                
                                
                                $category_repo = $em->getRepository("BlogBundle:Category");
                                $category = $category_repo->find($form->get("category")->getData());
                                $entry->setCategory($category);
                                
                                //$user = $this->get("security.context")->getToken()->getUser();
                                $user = $this->getUser();
                                $entry->setUser($user);
                                
                                $em->persist($entry);
                                $flush = $em->flush();
                                
                                if($flush == null){
                                        $status = "La entrada se ha creado correctamente";
                                } else{
                                        $status = "Error al crear la entrada !!";
                                }
                                
                        } else {
                                $status = "La entrada no se ha creado porque el formulario no es válido";
                        }

                        $this->session->getFlashBag()->add("status", $status);
                        //return $this->redirectToRoute("blog_index_entry");
                } 

                return $this->render("BlogBundle:Entry:add.html.twig", array(
                                'form' => $form->createView()
                        )
                );
        }
        
        public function editAction(Request $request, $id){
                $em = $this->getDoctrine()->getEntityManager();
                $category_repo = $em->getRepository("BlogBundle:Category");
                $category = $category_repo->find($id);
                
                $form = $this->createForm(CategoryType::class, $category);
                $form->handleRequest($request);
                
                if($form->isSubmitted()){
                        if($form->isValid()){
                                
                                $category->setName($form->get("name")->getData());
                                $category->setDescription($form->get("description")->getData());

                                $em->persist($category);
                                $flush = $em->flush();
                                
                                if($flush == null){
                                        $status = "La categoría se ha editado correctamente";
                                } else{
                                        $status = "Error al editar la categoría !!";
                                }
                                
                                
                        } else {
                                $status = "La categoría no se ha editado porque el formulario no es válido";
                        }

                        $this->session->getFlashBag()->add("status", $status);
                        return $this->redirectToRoute("blog_index_category");
                } 
                
                return $this->render("BlogBundle:Category:edit.html.twig", array(
                                'form' => $form->createView()
                        )
                );
                 
        }
        
        public function deleteAction($id){
                $em = $this->getDoctrine()->getEntityManager();
                $category_repo = $em->getRepository("BlogBundle:Category");
                $category = $category_repo->find($id);
                
                //FALTA VER LA SIGUIENTE LINEA
                if(count($category->getEntries()) == 0){
                    $em->remove($category);
                    $em->flush();
                }
                
                return $this->redirectToRoute("blog_index_category");
        }
    
}
