<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\PhoneNumber;
use App\Form\Type\UserRecordsForm;
use App\Service\UserService;

class UserController extends AbstractController
{
    public function __construct(BaseController $baseController)
    {
        $this->baseController = $baseController;
    }

   #[Route('api/user/add', name: 'add', methods: ['POST'])]
   public function insert(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
   {
    
    $user = new User;
    $phoneNumber = new PhoneNumber;
    $phoneNumber = $user->addPhoneNumber($phoneNumber);
    $createForm = $this->createForm(UserRecordsForm::class, $user);
    $createForm->handleRequest($request);
    $createForm->submit(json_decode($request->getContent(), true));
    if($createForm->isSubmitted() && $createForm->isValid()) {
         $user = $createForm->getData();
         $entityManager = $doctrine->getManager();
         $entityManager->persist($user);
         $entityManager->flush();
         $success=$this->baseController->successResponse();
         return new JsonResponse($success);
     }
     $failure = $this->baseController->failureResponse();
     return new JsonResponse($failure);  
   }

   #[Route('/api/user/display/{id}', name: 'display', methods: ['GET'])]
   public function display(ManagerRegistry $doctrine, $id): Response
   {
        $displayData = new UserService();
        $datas= $displayData->displayData($doctrine, $id);
        return new Response($this->json($datas));
   }

   #[Route('/api/user/delete/{id}', name: 'delete', methods: ['DELETE'])]
   public function delete(ManagerRegistry $doctrine, $id): Response
   {
        $baseController = new BaseController();
        $data = $doctrine->getManager();
        $record = $doctrine->getRepository(User::class)->find($id);
        if($record) {
		    $data->remove($record);
            $data->flush();
            $success=$this->baseController->successResponse();
            return new JsonResponse($success);
        }
        $failure = $this->baseController->failureResponse();
        return new JsonResponse($failure);
   }

   #[Route('/api/user/update/{id}', name: 'update', methods: ['PATCH'])]
   public function update(ManagerRegistry $doctrine ,$id, Request $request): Response
   {
        $user = new User();
        $entityManager = $doctrine->getManager();
        $data = $entityManager->getRepository(User::class)->find($id);
        $createForm = $this->createForm(UserRecordsForm::class, $data);
        $createForm->handleRequest($request);
        $data = $createForm->getData();
        $createForm->submit(json_decode($request->getContent(), true));
        if($createForm->isSubmitted() && $createForm->isValid()) {
           $data = $createForm->getData();
           $entityManager = $doctrine->getManager();
           $entityManager->persist($data);
           $entityManager->flush();
           $success=$this->baseController->successResponse();
           return new JsonResponse($success);
        }
        $failure = $this->baseController->failureResponse();
        return new JsonResponse($failure);
    }
}