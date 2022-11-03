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
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class UserRecords extends AbstractController
{
  
     #[Route('/record/insert', name: 'create', methods: ['POST'])]
     public function insert(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
     {
        $user = new User;
        $phone = new PhoneNumber;
        $phone = $user->addPhoneNumber($phone);
        $formcreated = $this->createForm(UserRecordsForm::class, $user);
        $formcreated->handleRequest($request);
        $formcreated->submit(json_decode($request->getContent(), true));
        if($formcreated->isSubmitted() && $formcreated->isValid())
        {
            $user = $formcreated->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return new Response(Response::HTTP_CREATED);
        }
        //dd($formcreated);
        return new Response(Response::HTTP_ACCEPTED);  
     }
    #[Route('/record/display/{id}', name: 'display', methods: ['GET'])]
    public function display(ManagerRegistry $doctrine, $id): Response
    {
        $record = new User;
        $phone = new PhoneNumber;

        $record = $record->addPhoneNumber($phone);
        $record->getPhoneNumbers();
        $entityManager = $doctrine->getManager();
        $record = $entityManager->getRepository(User::class)->find($id);
        $datass =  [
                 'id'=> $record->getId(),
                 'FirstName'=>$record->getFirstName(),
                 'LastName'=>$record->getLastName(),
                 'BloodGroup'=>(string)$record->getBloodGroup(),
                 'Gender'=>(string)$record->getGender(),
                 'PhoneNumber'=>json_encode($record->getPhoneNumbers()),
                ];
        return $this->json($datass); 
    }
    #[Route('/record/delete/{id}', name: 'delete', methods: ['DELETE'])]
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
    #[Route('/record/update/{id}', name: 'update', methods: ['PATCH'])]
    public function update(ManagerRegistry $doctrine ,$id, Request $request): Response
   {
            $user = new User();
            $entityManager = $doctrine->getManager();
            $data = $entityManager->getRepository(User::class)->find($id);
            $formcreated = $this->createForm(UserRecordsForm::class, $data);
            $formcreated->handleRequest($request);
            $data = $formcreated->getData();
            $formcreated->submit(json_decode($request->getContent(), true));
            if($formcreated->isSubmitted() && $formcreated->isValid())
            {
               $data = $formcreated->getData();
               $entityManager = $doctrine->getManager();
               $entityManager->persist($data);
               $entityManager->flush();
               return new Response(Response::HTTP_CREATED);
            }
            dd($formcreated);
            return new Response(Response::HTTP_NOT_FOUND);

   }
}