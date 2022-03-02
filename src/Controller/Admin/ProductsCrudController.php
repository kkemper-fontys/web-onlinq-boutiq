<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ProductsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Product')
            ->setEntityLabelInPlural('Products')
            ->showEntityActionsInlined()
            ->renderContentMaximized()
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('Name')->setRequired(true);
        if (Crud::PAGE_INDEX !== $pageName) {
            yield TextField::new('description')->setFormType(CKEditorType::class);
        }
        yield MoneyField::new('pricePerUnit')->setCurrency('EUR')->setNumDecimals(2)->setRequired(true)->setTextAlign('left');
        yield IntegerField::new('stock');
        yield TextField::new('unitType');
        yield AssociationField::new('Tags')->autocomplete(true);
    }
}
