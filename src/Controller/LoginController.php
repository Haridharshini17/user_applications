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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    
    #[Route("/api/login/form", name:"login", methods: ['POST'])]
    public function Login(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager, Connection $conn): Response
    {
       $user = new EndUser;
       $formcreated = $this->createForm(LoginForm::class, $user);
       $formcreated->handleRequest($request);
       $formcreated->submit(json_decode($request->getContent(), true));
       if($formcreated->isSubmitted() && $formcreated->isValid())
       {
        $user = new EndUser;
        $email = $formcreated["email"]->getData();
        $password = $formcreated["password"]->getData();
        $roles = json_encode($formcreated["roles"]->getData());
        $users = $conn->fetchAllAssociative('SELECT *FROM EndUser where email = "'.$email.'" AND password = "'.$password.'"');
        $results = json_encode($users);
        if(!empty($users))
       {
          return new RedirectResponse("http://localhost:8000/record/display/50");
       }
      else
      {
             echo "failure";
      }
       }
      // dd($formcreated->getErrors());
        return new Response(Response::HTTP_BAD_REQUEST);
    }
}
?>