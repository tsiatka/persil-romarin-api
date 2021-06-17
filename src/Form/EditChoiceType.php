<?php

namespace App\Form;

use App\Entity\Choice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;


class EditChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', TextType::class, ['required' => true])
            ->add('description', TextType::class, ['required' => false])
            ->add('fichier', VichFileType::class, [
                'label' => 'Image',
                'required' => false,
                'allow_delete' => false,
                'download_label' => true,
                'download_uri' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Choice::class,
        ]);
    }
}
