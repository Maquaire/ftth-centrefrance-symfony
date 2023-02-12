<?php

namespace App\Form;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {                           
        $builder
            ->add('email', EmailType::class, [
                "attr" => [
                    "class"    => "form-control fst-italic text-black",
                    "required" => true,
                ]
            ])
            ->add('firstname', TextType::class, [
                "attr" => [
                    "class"    => "form-control fst-italic text-black",
                    "required" => true,
                ]
            ])
            ->add('lastname', TextType::class, [
                "attr" => [
                    "class"    => "form-control fst-italic text-black",
                    "onkeyup"  => "this.value=this.value.toUpperCase()",
                    "required" => true
                ],
            ])
            ->add('manager', EntityType::class, [
                "class"         => User::class, 
                "placeholder" => "Choisir un manager",
                "choice_label"  => function(User $user) {
                    return $user->getLastname().' '.$user->getFirstname();
                },
                "query_builder" => function(UserRepository $userRepository) {
                    return $userRepository->findByManager();
                },
                "attr" => [
                    "class"    => "form-control fst-italic text-black",
                    "required" => true,
                ],
                "mapped" => false,
            ])
            ->add('job', ChoiceType::class, [
                "choices" => [
                    "Chef De Projet"                => "Chef De Projet",
                    "Responsable De Production"     => "Responsable De Production",
                    "Conducteur De Travaux"         => "Conducteur De Travaux",
                    "Superviseur De Travaux"        => "Superviseur De Travaux",
                    "Technicien Télécom Optique"    => "Technicien Télécom Optique",
                    "Technicien De Renfort"         => "Technicien De Renfort"
                ],
                "preferred_choices" => ["Technicien Télécom Optique", "TTO"],
                "attr" => [
                    "class"     => "form-control fst-italic text-black",
                    "required"  => true,
                ]
            ])
            ->add('upr', ChoiceType::class, [
                "choices" => [
                    "UPR01 - Paris"         => "01",
                    "UPR02 - Paris"         => "02",
                    "UPR03 - Paris"         => "03",
                    "UPR04 - Paris"         => "04",
                    "UPR05 - Lille"         => "05",
                    "UPR06 - Rouen"         => "06",
                    "UPR07 - Nantes"        => "07",
                    "UPR08 - Tours"         => "08",
                    "UPR09 - Bordeaux"      => "09",
                    "UPR10 - Montpellier"   => "10",
                    "UPR11 - Nice"          => "11",
                    "UPR12 - Lyon"          => "12",
                    "UPR13 - Dijon"         => "13",
                    "UPR14 - Strasbourg"    => "14",
                    "UPR15 - Marseille"     => "15",
                    "UPR16 - Grenoble"      => "16",
                    "UPR17 - Paris"         => "17",
                    "UPR18 - Paris"         => "18",
                    "UPR19 - Paris"         => "19",
                    "UPR20 - Paris"         => "20",
                ],
                "preferred_choices" => ["UPR08 - Tours", "08"],
                "attr" => [
                    "class"     => "form-control fst-italic text-black",
                    "required"  => true,
                ]
            ])
            ->add('submit', SubmitType::class, [
                "label" => $options["labelButton"],
                "attr" => [
                    "class" => "btn btn-blue",
                ]

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'labelButton' => 'Confirmer'
        ]);
    }
}
