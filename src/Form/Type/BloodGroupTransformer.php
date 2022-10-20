<?php
namespace App\Form\Type;

use App\Entity\BloodGroup;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

Class BloodGroupTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($bloodGroup): string
    {
        if (null === $bloodGroup) {
            return "";
        }
        return $bloodGroup->getBloodGroup();
    }
    public function reverseTransform($bloodGroup): ?BloodGroup
    {
        if(!$bloodGroup) {
            return null;
        }

        $bloodGroup = $this->entityManager
            ->getRepository(BloodGroup::class)
            ->find($bloodGroup)
        ;

        if (null === $bloodGroup) {
            throw new TransformationFailedException(sprintf(
                'An Bloodgroup "%s" does not exist!',$bloodGroup
            ));
        }

        return $bloodGroup;
    }
}
