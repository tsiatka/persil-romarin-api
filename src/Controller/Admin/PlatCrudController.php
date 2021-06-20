<?php

namespace App\Controller\Admin;

use App\Entity\Plat;
use App\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PlatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Plat::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('nom', "Nom du plat"),
            DateField::new('startedAt', "Début de disponibilité du plat"),
            DateField::new('finishedAt', "Fin de disponibilité du plat"),
            NumberField::new('calories', "Calories"),
            ChoiceField::new('allergies')->setChoices(
                [
                    'allergie 1' => 'allergie_1',
                    'allergie 2' => 'allergie_2',
                ]
            ),
        ];
        if ($pageName == Crud::PAGE_DETAIL) {
            $fields[] = VichImageField::new('nomFichierOriginal', 'Image');
        }
        if ($pageName == Crud::PAGE_NEW) {
            $fields[] = VichImageField::new('fichier', "Image")->setFormTypeOptions([
                'required' => false,
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
