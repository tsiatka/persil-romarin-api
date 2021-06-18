<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use App\Form\QuestionChoiceType;
use App\Form\EditChoiceType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use phpDocumentor\Reflection\Types\Boolean;

class QuestionCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Question::class;
    }
    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addJsFile('build/questioncrud.js')->addCssFile('build/questioncrud.css');
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['ordre' => 'ASC']);
    }
    public function configureFields(string $pageName): iterable
    {
        $fields =  [
            IntegerField::new('ordre', 'Ordre de la question')->setFormTypeOptions(['attr' => ['min' => 1]]),
            BooleanField::new('requis', 'Obligatoire'),
            TextField::new('label', 'Label/Intitulé de la question'),
            TextField::new('description', 'Description de la question'),
            ChoiceField::new('type', 'Type de question')->setChoices(
                [
                    'Bloc' => 'block',
                    'Choix multiples' => 'checkbox_multiple',
                    'Choix unique' => 'checkbox_unique',
                    'Select' => 'select',
                    'Input/Texte à saisir' => 'input'
                ]
            )
        ];
        if ($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL) {
            $fields[] = AssociationField::new('choice', 'Choix de réponses')->setTemplatePath('custom_fields/choices.html.twig')->onlyOnDetail();
        }
        if ($pageName == Crud::PAGE_NEW  || $pageName == Crud::PAGE_EDIT) {
            $fields[] = CollectionField::new('choice', 'Choix de réponses')->setEntryIsComplex(true)->setFormTypeOptions([
                "allow_delete" => true, 'required' => true,
            ])->setEntryType(QuestionChoiceType::class)->addCssClass('not-required')->onlyWhenCreating();
        }
        if ($pageName == Crud::PAGE_EDIT) {
            $fields[] = CollectionField::new('choice', 'Choix de réponses')->setEntryIsComplex(true)->setFormTypeOptions([
                "allow_delete" => true, 'required' => true,
            ])->setEntryType(EditChoiceType::class)->addCssClass('not-required')->onlyWhenUpdating();
        }
        return $fields;
    }
}
