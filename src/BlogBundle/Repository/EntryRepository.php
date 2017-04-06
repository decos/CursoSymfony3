<?php
//Indicar en que bundle esta
namespace BlogBundle\Repository;
//Extender desde EntityRepository
use Doctrine\ORM\EntityRepository;
use BlogBundle\Entity\Tag;
use BlogBundle\Entity\EntryTag;

class EntryRepository extends EntityRepository{
    
        //Insertar el nuevo Tag en la tabla Tags
        //Insertar la relacion que se crea entre el Tag y la Entrada
        public function saveEntryTags($tags=null, $title=null, $category=null, $user=null,
                $entry=null){
            
                $em  = $this->getEntityManager();
                $tag_repo  = $em->getRepository("BlogBundle:Tag");
                
                //Buscar la entrada si en caso que sea null
                if($entry == null){
                        $entry = $this->findOneBy(array(
                                'title' => $title,
                                'category' => $category,
                                'user' => $user
                        ));
                } else{
                        //
                }
                
                //Hacer un arreglo de tags partiendo de los tags ingresados x el formulario
                $tags = explode(",", $tags);
                
                //Buscar cada tag del arreglo tags
                foreach ($tags as $tag){
                        $isset_tag = $tag_repo->findOneBy(array("name" => $tag));
                        
                        if(count($isset_tag) == 0){
                                $tag_obj = new Tag();
                                $tag_obj->setName($tag);
                                $tag_obj->setDescription($tag);
                                $em->persist($tag_obj);
                                $em->flush();
                        }
                        
                        //Sacar el objeto de la Tabla
                        $tag = $tag_repo->findOneBy(array("name" => $tag));
                        
                        //Tabla que relaciona las Entrys con las Tags
                        $entryTag = new EntryTag();
                        $entryTag->setEntry($entry);
                        $entryTag->setTag($tag);
                        $em->persist($entryTag);
                }
                $flush = $em->flush();
                
        }
    
}
