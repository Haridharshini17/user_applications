<?php
namespace App\Form\Type;

use App\Entity\EndUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginForm extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
    ->add('id', IntegerType::class)
    ->add('userName', TextType::class)
    ->add('password', TextType::class)
    ->add('Roles',TextType::class)
    ->getForm()
    ->add('Save', SubmitType::class);
 }
public function setDefaultOptions(OptionsResolver $resolver): void
{
    $resolver->setDefaults(array(
        'data_class' => EndUser::class,
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