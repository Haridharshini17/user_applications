<?php
namespace App\Controller;

use App\Entity\EndUser;
use App\Form\Type\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends AbstractController
{

   #[Route("/api/login", name:'app_login', methods: ["POST"])]
   public function login(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager, Connection $conn): Response
   {
      $user = new EndUser;
      $createForm = $this->createForm(LoginForm::class, $user);
      $createForm->handleRequest($request);
      $createForm->submit(json_decode($request->getContent(), true));
      if($createForm->isSubmitted() && $createForm->isValid())
      {
         $user = new EndUser;
         $email = $createForm["email"]->getData();
         $password = $createForm["password"]->getData();
         $users = $conn->fetchAllAssociative('SELECT *FROM EndUser where email = "'.$email.'" AND password = "'.$password.'"');
         if(!empty($users))
         {
            return new RedirectResponse("http://localhost:8000/record/display/50");
         }
         else
         {
            echo "failure";
         }
      }
      return new Response(Response::HTTP_BAD_REQUEST);
   }
}
?>