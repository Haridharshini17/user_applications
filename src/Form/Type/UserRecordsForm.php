<?php
namespace App\Form\Type;

use App\Entity\BloodGroup;
use App\Entity\User;
use App\Entity\Gender;
use App\Repository\BloodGroupRepository;
use App\Repository\GenderRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use symfony\component\OptionsResolver\OptionsResolver;

class UserRecordsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('FirstName', TextType::class)
        ->add('LastName', TextType::class)
        ->add('BloodGroup',EntityType::class, array(
            'class' => BloodGroup::class,
            'choice_label' => 'bloodGroup',
            'query_builder' => function(BloodGroupRepository $repo) {
                return $repo->createQueryBuilder('b');
            }
        ))
        ->add('gender',EntityType::class, array(
            'class' => Gender::class,
            'choice_label' => 'gender',
            'query_builder' => function(GenderRepository $repo) {
                return $repo->createQueryBuilder('g');
            }
        ))
        
        ->add('Save', SubmitType::class);
    }
    public function setDefaultOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => null,
            // 'data_class' => BloodGroup::class,
            // 'data_class' => Gender::class
        ));
    }
}

?>