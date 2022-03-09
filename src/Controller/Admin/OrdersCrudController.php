<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class OrdersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
//            ->disable(Crud::PAGE_NEW)
            ->disable(Crud::PAGE_EDIT)
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('customer')->autocomplete(true);
    }
}
