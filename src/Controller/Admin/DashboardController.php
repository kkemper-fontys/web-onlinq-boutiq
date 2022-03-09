<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Customer;

use App\Entity\Tags;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use PhpParser\Node\Stmt\Label;
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

    function configureAssets(): Assets
    {
        return Assets::new()
            ->addJsFile('bundles/fosckeditor/ckeditor.js');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'admin');
        yield MenuItem::linkToCrud('Customer', 'fas fa-user', Customer::class);
        yield MenuItem::linkToCrud('Product', 'fas fa-box', Product::class);
        yield MenuItem::linkToCrud('Tags', 'fas fa-tags', Tags::class);
        yield MenuItem::linkToCrud('Order', 'fas fa-shopping-basket', Order::class);
    }
}
