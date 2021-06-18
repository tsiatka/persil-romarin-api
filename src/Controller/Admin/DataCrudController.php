<?php

namespace App\Controller\Admin;

use App\Entity\Data;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DataCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Data::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom_data'),
            AssociationField::new('question'),
        ];
    }
}
