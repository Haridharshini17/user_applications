<?php
namespace App\Form\Type;
use App\Entity\User;
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
        return $bloodGroup->getbloodgroup();
    }
    public function reverseTransform($Id): ?BloodGroup
    {
        
        if (!$Id) {
            return null;
        }

        $bloodGroup = $this->entityManager
            ->getRepository(BloodGroup::class)
            ->find($Id)
        ;

        if (null === $bloodGroup) {
            throw new TransformationFailedException(sprintf(
                'An blood group "%s" does not exist!',
                $Id
            ));
        }

        return $bloodGroup;
    }
}
