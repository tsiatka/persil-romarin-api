<?php

namespace App\Controller\Admin;

use App\Entity\Placeholder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PlaceholderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Placeholder::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
