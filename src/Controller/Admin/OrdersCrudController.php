<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\Customer;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

class OrdersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Crud::PAGE_EDIT)
            ;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        return $response;

    }

    public function configureFields(string $pageName): iterable
    {
        if($pageName === Crud::PAGE_INDEX){
            yield AssociationField::new('customer')->autocomplete()->setLabel('Klant');
        } else {
            yield AssociationField::new('customer')->autocomplete()->setLabel('Klant')
                ->setTemplatePath('admin/customer_field.html.twig');
        }

        yield DateTimeField::new('createdAt')->setLabel('Aangemaakt op');

        if ($pageName === Crud::PAGE_INDEX) {
            yield CollectionField::new('orderLines')->setLabel("Aantal orderregels");
        } else {
            yield CollectionField::new('orderLines')
                ->setTemplatePath('admin/order_lines_field.html.twig');
            yield CollectionField::new('couponLines')
                ->setTemplatePath('admin/coupon_lines_field.html.twig');
            yield MoneyField::new('subTotal')->setCurrency('EUR');
        }
        yield MoneyField::new('total')->setCurrency('EUR')->setLabel('Totaal');
        if($pageName === Crud::PAGE_INDEX){
            yield TextField::new('orderStatus');
        }
    }
}
