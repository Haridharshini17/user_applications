<?php
namespace App\Form\Type;
use App\Entity\User;
use App\Entity\Gender;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

Class GenderTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($gender): string
    {
    
        if (null === $gender) {
            return "";
        }
        return $gender->getId();
    }
    public function reverseTransform($genderget): ?Gender
    {
        
        if (!$genderget) {
            return null;
        }

        $gender = $this->entityManager
            ->getRepository(Gender::class)
            ->find($genderget)
        ;

        if (null === $gender) {
            throw new TransformationFailedException(sprintf(
                'An blood group "%s" does not exist!',
                $genderget
            ));
        }

        return $gender;
    }
}