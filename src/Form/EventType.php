<?php
namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom de l\'événement',
                'attr' => [
                    'placeholder' => 'Soirée dégustation de Kwak'
                ]
            ])
            ->add('picture', UrlType::class, [
                'label' => 'Image',
                'help' => 'URL de l\'image'
            ])
            ->add('description', null, [
                'attr' => [
                    'rows' => 5,
                ]
            ])
            ->add('startAt', null, [
                'label' => 'Date de début',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'attr' => [
                    'class' => 'datetime-widget',
                ]
            ])
            ->add('endAt', null, [
                'label' => 'Date de fin',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'attr' => [
                    'class' => 'datetime-widget',
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix'
            ])
            ->add('capacity', null, [
                'label' => 'Capacité',
            ])
            ->add('category', null, [
                'choice_label' => 'name',
                'label' => 'Catégorie',
            ])
            ->add('place', null, [
                'choice_label' => 'name',
                'label' => 'Lieu',
                'placeholder' => 'A distance',
            ])
            ->add('rules', null, [
                'label' => 'Conditions d\'accès',
                'choice_label' => 'label',
                'expanded' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'button',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
