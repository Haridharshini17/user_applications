<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\component\Routing\Annotation\Route;
use Symfony\component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Entity\PhoneNumber;
use App\Form\Type\UserRecordsForm;
use Doctrine\ORM\EntityManagerInterface;

class UserRecords extends AbstractController
{
    #[Route('/userrecords' , name: 'userrecords',)]
    public function new(Request $request,EntityManagerInterface $entityManager): Response
   { 
      $datas = new User();
      $phone = new PhoneNumber();
      $datas->getPhoneNumber()->add($phone);
      $formcreated = $this->createForm(UserRecordsForm::class, $datas);
      $formcreated->handleRequest($request);
      if($formcreated->isSubmitted() && $formcreated->isValid())
      {
          $entityManager->persist($datas);
          $entityManager->flush();
          return new Response('Users records inserted successfully');
      }
      return $this->renderForm('userForm/new.html.twig',
      [
        'formcreated' => $formcreated,

      ]);
    }
    #[Route('/userrecords/{id}', name: 'record_show', methods: ['GET'])]
    public function show(ManagerRegistry $doctrine, int $id): Response
        {
          echo "hai";
            $record = $doctrine->getRepository(User::class)->find($id);
            var_dump(($record));
            if(!$record){
                throw $this->createNotFoundException('Not found');
            }
            return new Response('Display record of given id:'.$record->getbloodGroup());
        }
}