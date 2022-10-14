<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\component\Routing\Annotation\Route;
use Symfony\component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\Type\UserRecordsForm;
use Doctrine\ORM\EntityManagerInterface;

class UserRecords extends AbstractController
{
    #[Route('/userrecords' , name: 'userrecords',)]
    public function new(Request $request,EntityManagerInterface $entityManager): Response
   { 
      $datas = new User();
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
}