<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use BlogBundle\Entity\Category;
use BlogBundle\Form\CategoryType;

class CategoryController extends Controller
{
        private $session;

        public function __construct() {
            $this->session = new Session();
        }

        public function indexAction(){
                
                $em  = $this->getDoctrine()->getEntityManager();
                $category_repo = $em->getRepository("BlogBundle:Category");
                $categories = $category_repo->findAll();
            
                return $this->render("BlogBundle:Category:index.html.twig", array(
                                'categories' => $categories
                        )
                );
                
        }
        
        public function addAction(Request $request){

                $category  = new Category();
                $form = $this->createForm(CategoryType::class, $category);

                $form->handleRequest($request);

                if($form->isSubmitted()){
                        if($form->isValid()){
                                $category = new Category();
                                $category->setName($form->get("name")->getData());
                                $category->setDescription($form->get("description")->getData());

                                $em = $this->getDoctrine()->getEntityManager();
                                $em->persist($category);
                                $flush = $em->flush();
                                
                                if($flush == null){
                                        $status = "La categoría se ha creado correctamente";
                                } else{
                                        $status = "Error al crear la categoría !!";
                                }
                                
                                
                        } else {
                                $status = "La categoría no se ha creado porque el formulario no es válido";
                        }

                        $this->session->getFlashBag()->add("status", $status);
                        return $this->redirectToRoute("blog_index_category");
                } 

                return $this->render("BlogBundle:Category:add.html.twig", array(
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
