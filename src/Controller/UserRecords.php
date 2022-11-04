<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Entity\PhoneNumber;
use App\Form\Type\UserRecordsForm;
use Doctrine\ORM\EntityManagerInterface;

class UserRecords extends AbstractController
{
   #[Route('/insert/record', name: 'create', methods: ['POST'])]
   public function insert(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
   {
       $user = new User;
       $phoneNumber = new PhoneNumber;
       $phoneNumber = $user->addPhoneNumber($phoneNumber);
       $createForm = $this->createForm(UserRecordsForm::class, $user);
       $createForm->handleRequest($request);
       $createForm->submit(json_decode($request->getContent(), true));
       if($createForm->isSubmitted() && $createForm->isValid())
       {
            $user = $createForm->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return new Response(Response::HTTP_CREATED);
        }
        return new Response(Response::HTTP_ACCEPTED);  
   }
   #[Route('/display/record/{id}', name: 'display', methods: ['GET'])]
   public function display(ManagerRegistry $doctrine, $id): Response
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
        return $this->json($datas); 
   }
   #[Route('/delete/record/{id}', name: 'delete', methods: ['DELETE'])]
   public function delete(ManagerRegistry $doctrine, $id): Response
   {
        $data = $doctrine->getManager();
        $record = $doctrine->getRepository(User::class)->find($id);
        if(!$record)
        {
           return new Response(Response::HTTP_NOT_FOUND);
        }
        $data->remove($record);
        $data->flush();
        return new Response(Response::HTTP_NO_CONTENT);
   }
   #[Route('/update/record/{id}', name: 'update', methods: ['PATCH'])]
   public function update(ManagerRegistry $doctrine ,$id, Request $request): Response
   {
        $user = new User();
        $entityManager = $doctrine->getManager();
        $data = $entityManager->getRepository(User::class)->find($id);
        $createForm = $this->createForm(UserRecordsForm::class, $data);
        $createForm->handleRequest($request);
        $data = $createForm->getData();
        $createForm->submit(json_decode($request->getContent(), true));
        if($createForm->isSubmitted() && $createForm->isValid())
        {
           $data = $createForm->getData();
           $entityManager = $doctrine->getManager();
           $entityManager->persist($data);
           $entityManager->flush();
           return new Response(Response::HTTP_CREATED);
        }
        return new Response(Response::HTTP_NOT_FOUND);
    }
}