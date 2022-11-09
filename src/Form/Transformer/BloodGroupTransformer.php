<?php

namespace App\Form\Transformer;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use App\Entity\BloodGroup;

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
        if(!$bloodGroup)  {
           
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