<?php

namespace App\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\Transformer\BloodGroupTransformer;
use App\Form\Transformer\GenderTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use symfony\component\OptionsResolver\OptionsResolver;
use App\Entity\User;
use App\Form\Type\PhoneNumberForm;

class UserRecordsForm extends AbstractType
{
    private $bloodGroupTransformer;
    private $genderTransformer;

    public function __construct(BloodGroupTransformer $bloodGroupTransformer, GenderTransformer $genderTransformer)
    {
        $this->bloodGroupTransformer = $bloodGroupTransformer;
        $this->genderTransformer = $genderTransformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('id', IntegerType::class)
        ->add('firstName', TextType::class)
        ->add('lastName', TextType::class)
        ->add('bloodGroup',TextType::class)
        ->add('gender',TextType::class)
        ->add('phoneNumbers', CollectionType::class, [
            'entry_type' => PhoneNumberForm::class,   
            'entry_options' => ['label' => false],
            'allow_add' => true, 
            'by_reference' => false,
            'prototype'=> true
        ])
        ->getForm()
        ->add('Save', SubmitType::class);
        $builder->get('bloodGroup')
            ->addModelTransformer($this->bloodGroupTransformer);
        $builder->get('gender')
            ->addModelTransformer($this->genderTransformer);
    }
    public function setDefaultOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'allow_extra_fields' => true
        ));
    }
    public function getDefaultOptions(array $options)
    {
        return array(
            'csrf_protection' => false
        );
    }
}
?>