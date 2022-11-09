<?php

namespace App\Form\Transformer;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use App\Entity\Gender;

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
        
        return $gender->getgender();
    }

    public function reverseTransform($gender): ?Gender
    {
        if (!$gender)  {
           
            return null;
        }
        $gender = $this->entityManager
            ->getRepository(Gender::class)
            ->find($gender)
        ;
        if (null === $gender)  {
            throw new TransformationFailedException(sprintf(
                'An gender "%s" does not exist!',$gender
            ));
        }
       
        return $gender;
    }
}