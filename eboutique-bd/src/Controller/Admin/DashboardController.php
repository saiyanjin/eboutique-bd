<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Category;
use App\Entity\Media;
use App\Entity\Product;
use App\Controller\Admin\CategoryCrudController;
use App\Controller\Admin\MediaCrudController;
use App\Controller\Admin\ProductCrudController;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(CategoryCrudController::class)->generateUrl());

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // return $this->redirectToRoute('admin_user_index');

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('E Boutique');
    }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkTo(CategoryCrudController::class, 'Catégories', 'fas fa-tags');
        yield MenuItem::linkTo(MediaCrudController::class, 'Médias', 'fas fa-images');
        yield MenuItem::linkTo(ProductCrudController::class, 'Produits', 'fas fa-shopping-cart');
    }
}
