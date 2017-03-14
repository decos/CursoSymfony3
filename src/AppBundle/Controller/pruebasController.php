<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Curso;
//FORMULARIOS
use AppBundle\Form\CursoType;


class pruebasController extends Controller
{
    /*
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:pruebas:index.html.twig', [
            'texto' => "Te lo envio desde la accion del controlador 3"
            ]
        );
    }
    */
    
    public function indexAction(Request $request, $name, $page)
    {
        //REDIRECCIONAMIENTO
        
        //return $this->redirect($this->generateUrl("homepage"));
        //return $this->redirect($this->generateUrl("helloWorld"));
        /*
        return $this->redirect($this->container->get("router")->getContext()->getBaseUrl()."/pruebas/en/diego/abanto/25?hola=true");
            La página localhost no está funcionando
            localhost te redireccionó demasiadas veces.
        */
        //return $this->redirect($this->container->get("router")->getContext()->getBaseUrl()."/hello-world?hola=true");
        //return $this->redirect($request->getBaseUrl()."/hello-world?hola=false");
        
        //GET y POST
        
        //var_dump($request->query->get("hola")); 
        //var_dump($request->get("hola-post"));
        //die();
        
        $productos = array( 
                    array('producto' => 'Consola', 'precio' => 2),
                    array('producto' => 'Consola 2', 'precio' => 3),
                    array('producto' => 'Consola 3', 'precio' => 4),
                    array('producto' => 'Consola 4', 'precio' => 5),
                    array('producto' => 'Consola 5', 'precio' => 6)
                );
        
        $fruta = array('manzana' => 'golden',
                        'pera' => 'rica');
        
        // replace this example code with whatever you need
        return $this->render('AppBundle:pruebas:index.html.twig', [
                //'texto' => $name . " - " . $surname . " - " . $page
                'texto' => $name . " - " . $page,
                'productos' => $productos,
                'fruta' => $fruta
                ]
        );
    }
    
    public function createAction(){
        
        $curso = new Curso();
        $curso->setTitulo("Curso Symfony de Diego Abanto");
        $curso->setDescripcion("Curso completo de Symfony 3.0.9");
        $curso->setPrecio(90);
        
        $em = $this->getDoctrine()->getManager();
        //Guardar la data en el ORM
        $em->persist($curso);
        //Volcar los datos del ORM en la base de datos
        $flush=$em->flush();
        
        if($flush != null){
            echo "El curso no se ha creado bien !!";
        } else{
            echo "El curso se ha creado correctamente";
        }
        die();
    }
    
    public function readAction(){
        
        $em = $this->getDoctrine()->getManager();
        $cursos_repo = $em->getRepository("AppBundle:Curso");
        //$cursos =$cursos_repo->findAll();
        
        // ES CORRECTO
        //$curso_ochenta = $cursos_repo->findBy(array("precio"=>91));
        
        // ES CORRECTO
        $curso_ochenta = $cursos_repo->findOneByPrecio(92);
        
        echo $curso_ochenta->getTitulo();
        
        /*
        foreach($cursos as $curso){
            echo $curso->getTitulo()."<br/>";
            echo $curso->getDescripcion()."<br/>";
            echo $curso->getPrecio()."<br/><hr>";
        }*/
        
        die();
    }
    
    public function updateAction($id, $titulo, $descripcion, $precio){
        $em = $this->getDoctrine()->getManager();
        //Enlace entre el EM y nosotros para hacer consultas
        $cursos_repo = $em->getRepository("AppBundle:Curso");
        $curso = $cursos_repo->find($id);
        $curso->setTitulo($titulo);
        $curso->setDescripcion($descripcion);
        $curso->setPrecio($precio);
        
        $em->persist($curso);
        $flush=$em->flush();
        
        if($flush != null){
            echo "El curso NO SE HA ACTUALIZADO !!";
        } else{
            echo "El curso se ha ACTUALIZADO correctamente";
        }
        die();
        
    }
    
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $cursos_repo = $em->getRepository("AppBundle:Curso");
        $curso = $cursos_repo->find($id);
        
        
        $em->remove($curso);
        $flush=$em->flush();
        
        if($flush != null){
            echo "El curso NO SE HA ELIMINADO !!";
        } else{ 
            echo "El curso se ha ELIMINADO correctamente";
        }
        die();
        
    }
    
    //UTILIZANDO SQL NATIVO
    /*
    public function nativeSqlAction(){
        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();
        
        $query =  "SELECT * FROM cursos";
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
        
        $cursos = $stmt->fetchAll();
        
        foreach($cursos as $curso){
            echo $curso['titulo']."<br/>";
        }
        
        die();
        
    }*/
    
    //DOCTRINE TIENE UN PSEUDO-LENGUAJE SQL (DQL)
    /*public function nativeSqlAction(){
        $em = $this->getDoctrine()->getManager();
        
        //Sacara todo lo de la entidad AppBundle.Curso
        $query = $em->createQuery("
                SELECT c FROM AppBundle:Curso c
                 WHERE c.precio > :precio
            ")->setParameter("precio", "79");
        $cursos = $query->getResult();
        
        foreach($cursos as $curso){
            echo $curso->getTitulo()."<br/>";
        }
        
        die();
        
    }*/

    //QUERY BUILDER
    /*
    public function nativeSqlAction(){
        $em = $this->getDoctrine()->getManager();
        $cursos_repo = $em->getRepository("AppBundle:Curso");
        
        $query = $cursos_repo->createQueryBuilder("c")
                ->where("c.precio > :precio")
                ->setParameter("precio", "79")
                ->getQuery();
        
        $cursos = $query->getResult();
        
        foreach($cursos as $curso){
            echo $curso->getTitulo()."<br/>";
        }
        
        die();
        
    }*/
    
    
    //REPOSITORIO PERSONALIZADOS
    //Modelo de consulta, que hace operaciones con la base de datos
    public function nativeSqlAction(){
        $em = $this->getDoctrine()->getManager();
        $cursos_repo = $em->getRepository("AppBundle:Curso");
        
        $cursos = $cursos_repo->getCursos();
        
        foreach($cursos as $curso){
            echo $curso->getTitulo()."<br/>";
        }
        
        die();
    }
    
    
    //FORMULARIOS
    public function formAction(){
        
        $curso = new Curso();
        $form = $this->createForm(CursoType::class, $curso);
        
        return $this->render('AppBundle:pruebas:form.html.twig', [
                    'form' => $form->createView()
                ]
        );
        
    }
    
}
