<?php

namespace App\Controller\Admin;

use App\Entity\Choice;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ChoiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Choice::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $fields = [
            AssociationField::new('question', 'Lié à la question')->setFormTypeOptions([
                'required' => true,
            ]),
            TextField::new('label'),
            TextField::new('description'),
        ];
        if ($pageName == Crud::PAGE_DETAIL) {
            $fields[] = VichImageField::new('nomFichierOriginal', 'Image');
        }
        if ($pageName == Crud::PAGE_NEW) {
            $fields[] = VichImageField::new('fichier', "Image")->setFormTypeOptions([
                'required' => true,
            ]);
        }
        if ($pageName == Crud::PAGE_EDIT) {
            $fields[] = VichImageField::new('fichier', "Image")->setFormTypeOptions([
                'required' => false,
                'allow_delete' => false
            ]);
        }
        return $fields;
    }
}
