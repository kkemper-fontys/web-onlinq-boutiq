<?php

namespace App\Controller\Admin;

use App\Entity\Customers;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CustomersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Customers::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Customer')
            ->setEntityLabelInPlural('Customers')
            ->showEntityActionsInlined()
            ->renderContentMaximized()
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('firstName');
        yield TextField::new('lastName');
        yield EmailField::new('email');

        $createdAt = DateTimeField::new('createdAt')->setFormat("dd-MM-yyyy HH:mm");

        yield TextField::new('address');
        yield TextField::new('zipcode');
        yield TextField::new('city');

        if (Crud::PAGE_INDEX === $pageName) {
            yield $createdAt;
        }
    }
}
