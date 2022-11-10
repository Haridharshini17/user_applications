<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;
use App\Entity\Admin;
use App\Form\Type\LoginForm;

class LoginController extends AbstractController
{

   #[Route("/api/login", name:'app_login', methods: ["POST"])]
   public function login(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager, Connection $conn): Response
   {
      $user = new Admin;
      $createForm = $this->createForm(LoginForm::class, $user);
      $createForm->handleRequest($request);
      $createForm->submit(json_decode($request->getContent(), true));
      if($createForm->isSubmitted() && $createForm->isValid()) {
			$user = new Admin;
         $email = $createForm["email"]->getData();
         $password = $createForm["password"]->getData();
         $users = $conn->fetchAllAssociative('SELECT *FROM Admin where email = "'.$email.'" AND password = "'.$password.'"');

         return $users;
      }
	  $failure = [
		'message' => ["Please provide valid details to proceed login"]
	  ];
     
      return new JsonResponse($failure,Response::HTTP_BAD_REQUEST);
   }
}
?>