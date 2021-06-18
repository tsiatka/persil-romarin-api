<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Form\CaracteristiqueType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;

class ClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email'),
            CollectionField::new('caracteristiques')->setEntryType(CaracteristiqueType::class),
        ];
    }
}
