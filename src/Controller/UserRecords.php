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
use phpDocumentor\Reflection\DocBlock\Serializer as DocBlockSerializer;
use Symfony\Bridge\Doctrine\ManagerRegistry as DoctrineManagerRegistry;
use Symfony\Component\Messenger\Transport\Serialization\Serializer as SerializationSerializer;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class UserRecords extends AbstractController
{
  
    #[Route('/records', name: 'create', methods: ['POST'])]
     public function insert(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
     {
        $user = new User;
        $phone = new PhoneNumber;
        $phone = $user->addPhoneNumber($phone);
        $formcreated = $this->createForm(UserRecordsForm::class, $user);
        $formcreated->handleRequest($request);
       // $user = $formcreated->getData();
        $formcreated->submit(json_decode($request->getContent(), true));
        if($formcreated->isSubmitted() && $formcreated->isValid())
        {
            $user = $formcreated->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return new Response(Response::HTTP_CREATED);
        }
        dd($formcreated->getErrors());
        return new Response(Response::HTTP_ACCEPTED);  
     }
     #[Route('/record/{id}', name: 'recordsn_shows', methods: ['PUT'])]
     public function show(ManagerRegistry $doctrine, $id): Response
     {
        //$record = new User;
        $entityManager = $doctrine->getManager();
        $record = $entityManager->getRepository(User::class)->find($id);
        return new Response($record, Response::HTTP_ACCEPTED);   
     } 
    #[Route('/records/{id}', name: 'records_shows_correct', methods: ['PUT'])]
    public function display(ManagerRegistry $doctrine, $id, SerializerInterface $serializer): Response
    {
        $record = new User;
        $phone = new PhoneNumber;
       $record->addPhoneNumber($phone);
        //$record->setCreatedAt(new \DateTime('now'));
        $entityManager = $doctrine->getManager();
        $record = $entityManager->getRepository(User::class)->find($id);
        $datass =  [
                 'id'=> $record->getId(),
                 'FirstName'=>$record->getFirstName(),
                 'LastName'=>$record->getLastName(),
                 'BloodGroup'=>(string)$record->getBloodGroup(),
                 'Gender'=>(string)$record->getGender(),
                 'PhoneNumber'=>$record->getPhoneNumbers(),
                ];
        return $this->json($datass); 
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
    #[Route('/record/update/{id}', name: 'update_record', methods: ['PATCh'])]
    public function update(ManagerRegistry $doctrine ,$id, Request $request): Response
   {
    
             $entityManager = $doctrine->getManager();
             $data = $entityManager->getRepository(User::class)->find($id);
            //dd($data);
            // $paramater = json_decode($request->getContent(), true);
           // dd($paramater);
            $data->setFirstName($data->firstName);
            $data->setLastName($data->lastName);
            $data->setBloodGroup($data->bloodGroup);
            $data->setGender($data->gender);
           // $data->addPhoneNumber($data->phoneNumbers);
            $entityManager->flush();
             $data =  [
                'id' => $data->getId(),
                'FirstName' => $data->getFirstName(),
                'LastName' => $data->getlastName(),
                'BloodGroup' => (string)$data->getBloodGroup(),
                'Gender' => (string)$data->getGender(),
               //'PhoneNumber' =>$data->getphoneNumbers()
            ];
              
            return $this->json($data);
             return $this->json([
               'added successfully'
            ]);  
   }
           
                  


}
