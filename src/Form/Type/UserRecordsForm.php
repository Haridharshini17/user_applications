<?php
namespace App\Form\Type;

use App\Entity\BloodGroup;
use App\Entity\User;
use App\Entity\Gender;
use App\Entity\PhoneNumber;
use App\Form\Type\PhoneNumberForm;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Repository\BloodGroupRepository;
use App\Repository\GenderRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\Type\BloodGroupTransformer;
use App\Form\Type\GenderTransformer;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use symfony\component\OptionsResolver\OptionsResolver;

class UserRecordsForm extends AbstractType
{
    private $transformer;
    public function __construct(BloodGroupTransformer $bloodGroupTransformer)
    {
        $this->transformer = $bloodGroupTransformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstName', TextType::class)
        ->add('lastName', TextType::class)
        ->add('bloodGroup',EntityType::class, array(
            'class' => BloodGroup::class,
            'choice_label' => 'bloodGroup',
            'choice_filter' => 'isSelectable',
            'query_builder' => function(BloodGroupRepository $repo) {
               return $repo->createQueryBuilder('b');
           },
            // 'choice_filter' => 'isSelectable',
        ))
        ->add('gender',EntityType::class, array(
            'class' => Gender::class,
            'choice_label' => 'gender',
            'choice_filter' => 'isSelectable',
            'query_builder' => function(GenderRepository $repo) {
                return $repo->createQueryBuilder('g');
            }
        ))
        ->add('phoneNumber', CollectionType::class, [
            'label' => false,
            'entry_type' => PhoneNumberForm::class,
            'entry_options' => array('label' => false)            
        ])
         ->getForm()
         
        ->add('Save', SubmitType::class);
        $builder->get('bloodGroup')
            ->addModelTransformer($this->transformer);
        $builder->get('gender')
            ->addModelTransformer($this->transformer);
     }
    public function setDefaultOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => null,
             'allow_extra_fields' => true
            // 'data_class' => BloodGroup::class,
            // 'data_class' => Gender::class
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