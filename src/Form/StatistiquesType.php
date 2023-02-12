<?php

namespace App\Form;

use App\Entity\Statistiques;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatistiquesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder            
            ->add('pp37', IntegerType::class, [
                "attr" => [
                    "class"    => "form-control fst-italic text-black",
                    "required" => true,
                    "placeholder" => '0'
                ],
            ])
            ->add('sav37', IntegerType::class, [
                "attr" => [
                    "class"    => "form-control fst-italic text-black",
                    "required" => true,
                     "placeholder" => '0',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Statistiques::class,
        ]);
    }
}
