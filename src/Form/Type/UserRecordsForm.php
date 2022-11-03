<?php
namespace App\Form\Type;

use App\Entity\User;

use App\Form\Type\PhoneNumberForm;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\Type\BloodGroupTransformer;
use App\Form\Type\GenderTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use symfony\component\OptionsResolver\OptionsResolver;


class UserRecordsForm extends AbstractType
{
    private $transformer;
    private $transformer1;
    public function __construct(BloodGroupTransformer $bloodGroupTransformer, GenderTransformer $genderTransformer)
    {
        $this->transformer = $bloodGroupTransformer;
        $this->transformer1 = $genderTransformer;
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
            ->addModelTransformer($this->transformer);
        $builder->get('gender')
            ->addModelTransformer($this->transformer1);
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