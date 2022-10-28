<?php
namespace App\Controller;

use App\Entity\EndUser;
use App\Form\Type\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    
    #[Route("/login", name:"login", methods: ['POST'])]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
       $user = new EndUser;
       $formcreated = $this->createForm(LoginForm::class, $user);
       $formcreated->handleRequest($request);
       $formcreated->submit(json_decode($request->getContent(), true));
       if($formcreated->isSubmitted() && $formcreated->isValid())
       {
           $error = $authenticationUtils->getLastAuthenticationError();
           $lastUsername = $authenticationUtils->getLastUsername();
           return new Response(Response::HTTP_CREATED);
       }
        return new Response(Response::HTTP_BAD_REQUEST);
    }
}
?>