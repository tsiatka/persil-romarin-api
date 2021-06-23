<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Form\CaracteristiqueType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;

class ClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            EmailField::new('email'),
            CollectionField::new('caracteristiques')->setEntryType(CaracteristiqueType::class)->onlyOnForms(),
        ];
        if ($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL) {
            $fields[] = AssociationField::new('caracteristiques', 'Caractéristiques')->setTemplatePath('custom_fields/caracteristiques.html.twig')->onlyOnDetail();
        }
        return $fields;
    }
}
