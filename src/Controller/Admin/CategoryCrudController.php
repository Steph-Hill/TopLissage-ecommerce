<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), // Champ "id" masqué dans le formulaire d'édition
            TextField::new('name'), // Champ "name" affiché en tant que champ de texte
            DateTimeField::new('updatedAt')->hideOnForm(), // Champ "updatedAt" masqué dans le formulaire d'édition
            DateTimeField::new('createdAt')->hideOnForm(), // Champ "createdAt" masqué dans le formulaire d'édition
        ];
    }
    

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /* Controle si la variable $entityInstance est une instance de la classe Catégory */
        if (!$entityInstance instanceof Category ) {
            
            return;
        }
        /* si elle n'existe pas on cree le champ CreatedAT avec le type DateTimeImmutable */
        $entityInstance->setCreatedAt(new \DateTimeImmutable);

        /* Utiliser la fonctionnalité presente dans l'AbstractController */
        parent::persistEntity($entityManager, $entityInstance);

    }


    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        

        $entityInstance->setUpdatedAt(new \DateTimeImmutable);

        parent::updateEntity($entityManager,$entityInstance);
        
    }
 
    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Category) {
            return;
        }

        foreach($entityInstance->getProducts() as $product){

            $entityManager->remove($product);

        }

        parent::deleteEntity($entityManager, $entityInstance);

    }

}
