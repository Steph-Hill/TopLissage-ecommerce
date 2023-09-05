<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Transporter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;



#[Route('/admin')]
class DashboardController extends AbstractDashboardController
{

    public function __construct( private AdminUrlGenerator $adminUrlGenerator){
        
    }

    #[Route('/mon-dash', name: 'admin')]
    public function index(): Response
    {
        try {
            // Vérification de l'accès avec le rôle ROLE_ADMIN
            $this->denyAccessUnlessGranted("ROLE_ADMIN");

            // Génération de l'URL pour le CRUD de l'entité Product
            $url = $this->adminUrlGenerator
                ->setController(ProductCrudController::class)
                ->generateUrl();

            // Redirection vers l'URL du CRUD de l'entité Product
            return $this->redirect($url);
        } catch (AccessDeniedException $exception) {
            // Gestion de l'exception d'accès refusé
            $this->addFlash('danger', "Cette partie du site est réservée.");

            if ($this->isGranted("ROLE_USER")) {
                // Redirection vers le tableau de bord utilisateur
                return $this->redirectToRoute('user_dashboard');
            } else {
                // Redirection vers la page de connexion
                return $this->redirectToRoute('app_login');
            }
        }
    }
    
// Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');

        
    // Configuration des éléments de menu
    public function configureMenuItems(): iterable
    {
        // Section principale "E-commerce"
        yield MenuItem::section('E-commerce', 'fa-solid fa-house');

        // Sous-menu "Ajouter éléments"
        yield MenuItem::subMenu('Ajouter éléments', 'fa-solid fa-list')->setSubItems([
            // Lien pour ajouter un nouveau produit
            MenuItem::linkToCrud('Nouveau Produit', 'fas fa-plus', Product::class)
                ->setAction(Crud::PAGE_NEW),

            // Lien pour ajouter une nouvelle catégorie
            MenuItem::linkToCrud('Nouvelle Catégorie', 'fas fa-plus', Category::class)
                ->setAction(Crud::PAGE_NEW),

            // Lien pour ajouter un nouveau transporteur
            MenuItem::linkToCrud('Nouveau Transporteur', 'fas fa-plus', Transporter::class)
                ->setAction(Crud::PAGE_NEW)
        ]);

        // Sous-menu "Afficher éléments"
        yield MenuItem::subMenu('Afficher éléments', 'fa-solid fa-list')->setSubItems([
            // Lien pour afficher tous les produits
            MenuItem::linkToCrud('Les Produits', 'fa-solid fa-warehouse', Product::class),

            // Lien pour afficher toutes les catégories
            MenuItem::linkToCrud('Les Catégories', 'fa-solid fa-newspaper', Category::class)
        ]);
    }
}
