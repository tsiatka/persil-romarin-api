<?php

namespace App\Controller\Admin;

use App\Entity\Placeholder;
use App\Entity\Question;
use App\Form\QuestionChoiceType;
use App\Form\EditChoiceType;
use App\Form\PlaceholderType;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
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
            IntegerField::new('ordre', 'Ordre')->setFormTypeOptions(['attr' => ['min' => 1]])->setHelp('Position de la question dans le Quiz'),
            BooleanField::new('requis', 'Obligatoire')->setFormTypeOptionIfNotSet('label_attr.class', 'switch-custom')->setHelp('Question obligatoire ou facultative dans le Quiz'),
            BooleanField::new('progress', 'ProgressBar')->setFormTypeOptionIfNotSet('label_attr.class', 'switch-custom')->setHelp('Si cochée, cette question fera avancer la barre de progression du Quiz'),
            TextField::new('dataName', 'Id')->setHelp('Identifiant de la question, nécessaire pour récupérer les données')->setFormTypeOptions([
                'required' => true
            ]),
            TextField::new('label', 'Label')->setHelp('Intitulé de la question'),
            TextareaField::new('description', 'Description')->setHelp('Intitulé de la question'),
            ChoiceField::new('type', 'Type de question')->renderAsNativeWidget(true)->setChoices(
                [
                    'Bloc' => 'block',
                    'Bloc4' => 'block4',
                    'Bloc6' => 'block6',
                    'Bloc16' => 'block16',
                    'Message à afficher' => 'text',
                    'Select' => 'select',
                    'Email' => 'email',
                    'Date' => 'date',
                    'Input Question 1' => 'input',
                    'Input/Texte à saisir' => 'input1',
                    '2 Input' => 'input2'
                ]
            )
        ];
        if ($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL) {
            $fields[] = AssociationField::new('placeholders', 'Placeholders')->setTemplatePath('custom_fields/placeholders.html.twig')->onlyOnDetail();
            $fields[] = AssociationField::new('choice', 'Choix de réponses')->setTemplatePath('custom_fields/choices.html.twig')->onlyOnDetail();
        }
        if ($pageName == Crud::PAGE_NEW) {
            $fields[] = CollectionField::new('placeholders', 'Placeholders')->setEntryIsComplex(true)->setFormTypeOptions([
                "allow_delete" => true, 'required' => true,
            ])->setEntryType(QuestionChoiceType::class)->onlyWhenCreating();
            $fields[] = CollectionField::new('choice', 'Choix de réponses')->setEntryIsComplex(true)->setFormTypeOptions([
                "allow_delete" => true, 'required' => true,
            ])->setEntryType(PlaceholderType::class)->onlyWhenCreating()->setHelp('Il est nécessaire de renseigner la question suivante');
        }
        if ($pageName == Crud::PAGE_EDIT) {
            $fields[] = CollectionField::new('placeholders', 'Placeholders')->setEntryIsComplex(true)->setFormTypeOptions([
                "allow_delete" => true, 'required' => true,
            ])->setEntryType(PlaceholderType::class)->addCssClass('not-required')->onlyWhenUpdating();
            $fields[] = CollectionField::new('choice', 'Choix de réponses')->setEntryIsComplex(true)->setFormTypeOptions([
                "allow_delete" => true, 'required' => true,
            ])->setEntryType(EditChoiceType::class)->addCssClass('not-required')->onlyWhenUpdating()->setHelp('Il est nécessaire de renseigner la question suivante');
        }
        return $fields;
    }
}
