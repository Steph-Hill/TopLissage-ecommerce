<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public const ACTION_DUPLICATE  = 'duplicate';

    public const PRODUCTS_PATH_BASE = 'upload/images/products';
    
    public const PRODUCTS_UPLOAD_DIR = 'public/upload/images/products';

    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureActions(Actions $actions): Actions
    {

        $duplicate = Action::new(self::ACTION_DUPLICATE)
                            ->linkToCrudAction('duplicateProduct')
                            ->setCssClass('btn btn-info');

        return $actions
        ->add(Crud::PAGE_EDIT,$duplicate);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextEditorField::new('description'),
            MoneyField::new('price')->setCurrency('EUR'),

            ImageField::new('image')
                        ->setBasePath(self::PRODUCTS_PATH_BASE)
                        ->setUploadDir(self::PRODUCTS_UPLOAD_DIR)
                        ->setSortable(false),
            AssociationField::new('category', 'Catégorie')->setFormTypeOptions([
                            'class' => Category::class,
                            'choice_label' => 'name',
                        ]),
            NumberField::new('quantity')->setStoredAsString(),
            DateTimeField::new('updatedAt')->hideOnForm(),
            DateTimeField::new('createdAt')->hideOnForm(),

        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Product) {
            return;
        }
        $entityInstance->setCreatedAt(new \DateTimeImmutable);

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Product) {
            return;
        }

        $entityInstance->setUpdatedAt(new \DateTimeImmutable);

        parent::updateEntity($entityManager,$entityInstance);
        
    }

    public function duplicateProduct(AdminContext $context, 
                    EntityManagerInterface $entityManager, 
                    AdminUrlGenerator $adminUrlGenerator):Response
    {
        /** @var Product $product */
        $product = $context->getEntity()->getInstance();

        $duplicateProduct = clone $product;

        parent::persistEntity($entityManager, $duplicateProduct);

        $url = $adminUrlGenerator->setController(self::class)
            ->setAction(Action::DETAIL)
            ->setEntityId($duplicateProduct->getId())
            ->generateUrl();

        return $this->redirect($url);

    }
   
}
