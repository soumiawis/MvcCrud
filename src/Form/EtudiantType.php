<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// make:form
class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('niveau', ChoiceType::class, [
                'choices'  => [
                    'B1' => 'B1',
                    'B2' => 'B2',
                    'B3' => 'B3',
                ]
            ])
            ->add('email', EmailType::class)
            ->add('tel',TelType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
