<?php
namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SearchEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('query', SearchType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Rechercher un événement',
                ],
            ])
            ->add('category', EntityType::class, [
                'label' => false,
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Filtrer par catégorie',
            ])
            ->add('free', CheckboxType::class, [
                'label' => 'Uniquement les événements gratuits'
            ])
            ->add('submit', SubmitType::class, [
                'label' => '<i class="fas fa-search"></i>',
                'label_html' => true,
                'attr' => [
                    'class' => 'button',
                ]
            ])
        ;

        $builder->setMethod('GET');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
