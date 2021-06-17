<?php

namespace App\Controller\Admin;

use App\Entity\Choice;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ChoiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Choice::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('question', 'Lié à la question')->setFormTypeOptions([
                'required' => true,
            ]),
            TextField::new('label'),
            TextField::new('description'),
        ];
    }
}
