<?php

namespace App\Controller\Admin;

use App\Entity\Coupon;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CouponCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Coupon::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('code')->setRequired(true);
        yield MoneyField::new('priceReduction')->setCurrency('EUR')->setNumDecimals(2);
        yield IntegerField::new('percentageReduction');
        yield IntegerField::new('timesUsable');
        if (Crud::PAGE_INDEX === $pageName) {
            yield IntegerField::new('timesUsed')->setHelp("vul 0 in voor onbeperkt");
        }
    }
}
