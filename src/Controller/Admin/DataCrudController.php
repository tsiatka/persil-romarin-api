<?php

namespace App\Controller\Admin;

use App\Entity\Data;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DataCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Data::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        $viewStat = Action::new('viewStat', 'Stats participants au quiz', 'fa fa-chart-pie')
            ->linkToRoute('view_stat', function (Data $data): array {
                return [
                    'id' => $data->getId(),
                ];
            });
        return $actions->add(Crud::PAGE_DETAIL, $viewStat)->add(Crud::PAGE_INDEX, $viewStat);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom_data'),
            AssociationField::new('question')->hideOnForm()->setFormTypeOptions([
                'by_reference' => false
            ]),
        ];
    }
}
