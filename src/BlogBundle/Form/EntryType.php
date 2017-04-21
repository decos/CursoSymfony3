<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EntryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title' , TextType::class, 
                        array("label" => "Título" , "required" => "required", 
                                "attr" => array( "class" => "form-control" )))
            ->add('content' , TextareaType::class, 
                        array("label" => "Contenido" , "required" => "required", 
                                "attr" => array( "class" => "form-control" )))
            ->add('status' , ChoiceType::class, 
                        array("label" => "Estado" , "choices" => array(
                                    "Público" => "public",
                                    "Privado" => "private"
                            ), "attr" => array( "class" => "form-control" )))
            ->add('image' , FileType::class, 
                        array("label" => "Imagen" , 
                                "attr" => array("class" => "form-control"),
                                "data_class" => null,
                                "required" => false
                        ))
            ->add('category' , EntityType::class,  //se conectara a doctrine para sacar la data de categoria
                        array("label" => "Categorías" , "class" => "BlogBundle:Category", 
                                "attr" => array( "class" => "form-control")))
            //campos referenciales
            ->add('tags' , TextType::class, 
                        array("label" => "Etiquetas" , "mapped" => false,
                                "attr" => array( "class" => "form-control" )))
            //submit
            ->add('Guardar', SubmitType::class,
                        array("attr" => array("class" => "form-submit btn btn-success")
                        ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Entry'
        ));
    }
}
