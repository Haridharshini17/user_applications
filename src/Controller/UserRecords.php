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
    #[Route('/userrecords' , name: 'userrecords', methods: ['POST'])]
    public function new(Request $request,EntityManagerInterface $entityManager): Response
   { 
      $datas = new User();
      $phone = new PhoneNumber();
      $datas->addPhoneNumber($phone);
      $formcreated = $this->createForm(UserRecordsForm::class, $datas);
      $formcreated->handleRequest($request);
      if($formcreated->isSubmitted() && $formcreated->isValid())
      {
          $entityManager->persist($datas);
          $entityManager->flush();
          return new Response(Response::HTTP_CREATED);
      }
      return new Response(Response::HTTP_OK);

    }
    #[Route('/records/{id}', name: 'records_shows', methods: ['PUT'])]
    public function display(ManagerRegistry $doctrine, $id): Response
    {
        $record = $doctrine->getRepository(User::class)->find($id);
        return new Response($record,Response::HTTP_FOUND);   
    }  
    #[Route('/record/delete/{id}', name: 'delete_record', methods: ['DELETE'])]
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
    #[Route('/record/update/{id}', name: 'update_record', methods: ['GET'])]
    public function update(ManagerRegistry $doctrine ,$id, Request $request): Response
    {
        $data = $doctrine->getManager();
        $record = $data->getRepository(User::class)->find($id);
        if (!$record) 
        {
          return new Response(Response::HTTP_NOT_FOUND);
        }
        $record->setFirstName($request->request->get('firstName'));
        $record->setLastName($request->request->get('lastName'));
        $record->setBloodGroup($request->request->get('BloodGroup'));
        $record->setGender($request->request->get('Gender'));
        $record->setPhoneNumber($request->request->get('PhoneNumber'));
        $data->flush();
        $datas =  [
            'id' => $record->getId(),
            'firstName' => $record->getFirstName(),
            'lastName' => $record->getLastName(),
            'BloodGroup' => $record->getBloodGroup(),
            'Gender' => $record->getGender(),
            'PhoneNumber' => $record->getPhoneNumber(),
        ];
        return new Response($datas[], Response::HTTP_OK);
    }
}