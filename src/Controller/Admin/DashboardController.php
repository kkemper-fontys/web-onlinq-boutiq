<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use App\Entity\Customers;

use App\Entity\Tags;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/cms", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(CustomersCrudController::class)->generateUrl();
        $url = $routeBuilder->setController(ProductsCrudController::class)->generateUrl();
        $url = $routeBuilder->setController(TagsCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Web Onlinq Boutiq');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'admin');
        yield MenuItem::linkToCrud('Customers', 'fas fa-user', Customers::class);
        yield MenuItem::linkToCrud('Products', 'fas fa-box', Products::class);
        yield MenuItem::linkToCrud('Tags', 'fas fa-tags', Tags::class);
    }
}
