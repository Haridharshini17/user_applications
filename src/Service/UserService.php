<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\PhoneNumber;
use App\Form\Type\UserRecordsForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserService extends AbstractController
{
    public function createData(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
       $user = new User;
       $phoneNumber = new PhoneNumber;
       $phoneNumber = $user->addPhoneNumber($phoneNumber);
       $createForm = $this->createForm(UserRecordsForm::class, $user);
       $createForm->handleRequest($request);
       $createForm->submit(json_decode($request->getContent(), true));
       if($createForm->isSubmitted() && $createForm->isValid()) {
            $user = $createForm->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            echo "hi";
            $entityManager->flush();
	        $success = [
				'message' => 'Successfully Added'
			];
            return new JsonResponse($success,Response::HTTP_CREATED);
        }
        $failure = [
              'message' => "Failed to add user"
       ];
       return new JsonResponse($failure,Response::HTTP_ACCEPTED);  
    }
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