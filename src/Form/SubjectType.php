<?php

namespace App\Form;

use App\Entity\Subject;
use App\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class,
            [
                'label' => 'Subject code',
                'required' => true,
                'attr' => ['minlength' => 4, 'maxlength' => 30]
            ])
            ->add('name', TextType::class,
            [
                'label' => 'Subject name',
                'required' => true,
                'attr' => ['minlength' => 4, 'maxlength' => 30]
            ])
            ->add('description', TextType::class,
            [
                'label' => 'Subject description',
                'required' => true,
                'attr' => ['minlength' => 4, 'maxlength' => 30]
            ])
            ->add('fee', MoneyType::class,
            [
                'label' => 'Subject fee',
                'required' => true,
                'currency' => 'VND'
            ])
            ->add('teachers', EntityType::class,
            [
                'label' => 'Teacher',
                'required' => true,
                'class' => Teacher::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Subject::class,
        ]);
    }
}
