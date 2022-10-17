<?php

namespace App\Controller;

use App\Entity\BloodGroup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Entity\PhoneNumber;
use App\Form\Type\UserRecordsForm;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class UserRecords extends AbstractController
{
  
    #[Route('/records', name: 'create', methods: ['POST'])]
     public function insert(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
     {
        $user = new User;
        $phone = new PhoneNumber;
        $user->addPhoneNumber($phone);
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
       // dd($formcreated->getErrors());
        return new Response(Response::HTTP_ACCEPTED);
        
     }
     #[Route('/records/{id}', name: 'records_shows', methods: ['PUT'])]
     public function show(ManagerRegistry $doctrine, $id): Response
     {
         $record = $doctrine->getRepository(User::class)->find($id);
         return new Response($record,Response::HTTP_FOUND);   
     }  
    #[Route('/userrecords' , name: 'userrecords', methods: ['POST'])]

    public function postAction(Request $request, ManagerRegistry $doctrine,EntityManagerInterface $entityManager): Response
    {
      $data = new User;
      $paramater = json_decode($request->getContent(), true);
      $data->setFirstName('firstName');
      $data->setLastName('lastName');
      $data->setBloodGroup($paramater['BloodGroup']);
      $data->setGender($paramater['gender']);
      $data->addPhoneNumber($paramater['phoneNumber']);
      $em = $doctrine->getManager();
      $em->persist($data);
      $em->flush();
      return new Response("User Added Successfully", Response::HTTP_OK);
    }
    
    #[Route('/records/{id}', name: 'records_shows', methods: ['PUT'])]
    public function display(ManagerRegistry $doctrine, $id): Response
    {
        $datas = new User;
        $phone = new PhoneNumber;
        $datas->addPhoneNumber($phone);
        $datas->setCreatedAt(new \DateTime('now'));
       // $jsonContent = $serializer->serialize($datas, 'json');
        $record = $doctrine->getRepository(User::class)->find($id);
        $data =  [
            'id' => $record->getId(),
            'firstName' => $record->getFirstName(),
            'lastName' => $record->getLastName(),
            'bloodGroup' =>$record->getBloodGroup(),
            'gender' => $record->getGender(),
            'phoneNumber' => $record->getPhoneNumber(),
        ];
        return new Response(json_encode($data)); 
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
             //$entityManager = $doctrine->getManager();
             $data = $doctrine->getRepository(User::class)->find($id);
            // $paramater = json_encode($request->getContent(), true);
             $data->getFirstName('FirstName');
             $data->getLastName(['lastName']);
             $data->getBloodGroup(['bloodGroup']);
             $data->getGender(['gender']);
             $data->getPhoneNumber(['phoneNumber']);
             $em = $doctrine->getManager();
             $em->persist($data);
             $em->flush();
             return $this->json([
               'added successfully'
            ]);    
    }
}