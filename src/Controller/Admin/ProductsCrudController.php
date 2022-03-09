<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ProductsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Product')
            ->setEntityLabelInPlural('Product')
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
        yield AssociationField::new('Tags')->autocomplete(true)->setHelp("<a href='cms?crudAction=new&crudControllerFqcn=App%5CController%5CAdmin%5CTagsCrudController&signature=gty7VM2vVBwwDrFPrZC50o4HjheZD5O7doqD24tSLfM'>Can't find the right Tag? Try to add tags!</a>");
        yield CollectionField::new('images')->allowAdd(true)->allowDelete(true)->setEntryType(FileUploadType::class)->setFormTypeOptions([
            'entry_options' => [
                'upload_filename' => '[slug]-[contenthash].[extension]',
            ]
        ]);
    }
}
