<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\PhoneNumber;

class UserService extends AbstractController
{
    public function displayData(ManagerRegistry $doctrine, $id)
    {
       $record = new User;
       $phoneNumber = new PhoneNumber;
       $record = $record->addPhoneNumber($phoneNumber);
       $record->getPhoneNumbers();
       $entityManager = $doctrine->getManager();
       $record = $entityManager->getRepository(User::class)->find($id);
       $datas = [
              'id'=> $record->getId(),
              'FirstName'=>$record->getFirstName(),
              'LastName'=>$record->getLastName(),
              'BloodGroup'=>(string)$record->getBloodGroup(),
              'Gender'=>(string)$record->getGender(),
              'PhoneNumber'=>json_decode(serialize($record->getPhonenumbers())),
             ];

        return $datas;
    }
}