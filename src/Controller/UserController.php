<?php

namespace App\Controller;

use App\Entity\PhoneNumber;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Service\UserService;

#[Route('api/user/')]
class UserController extends BaseController
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

   #[Route('add', name: 'add', methods: ['POST'])]
   public function insert(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
   {
        $user = new User();
        $phoneNumber = new PhoneNumber();
        $phoneNumber = $user->addPhoneNumber($phoneNumber);
        $createForm = $this->insertData($request, $user);
        if($createForm->isSubmitted() && $createForm->isValid()) {
            $this->dataConnection($createForm ,$doctrine ,$entityManager);
            $success = $this->successResponse();

            return new JsonResponse($success);
        }
        $failure = $this->failureResponse();

        return new JsonResponse($failure);  
   }

   #[Route('{id}', name: 'display', methods: ['GET'])]
   public function display(ManagerRegistry $doctrine, $id): Response
   {
        $records = $this->userService->displayData($doctrine, $id);

        return new Response($this->json($records));
   }

   #[Route('delete/{id}', name: 'delete', methods: ['DELETE'])]
   public function delete(ManagerRegistry $doctrine, $id): Response
   {
        $deleteData = $doctrine->getManager();
        $record = $doctrine->getRepository(User::class)->find($id);
        if($record) {
		    $deleteData->remove($record);
            $deleteData->flush();
            $success=$this->successResponse();

            return new JsonResponse($success);
        }
        $failure = $this->failureResponse();

        return new JsonResponse($failure);
   }

   #[Route('update/{id}', name: 'update', methods: ['PATCH'])]
   public function update(ManagerRegistry $doctrine ,$id, Request $request, EntityManagerInterface $entityManager): Response
   {
        $entityManager = $doctrine->getManager();
        $data = $entityManager->getRepository(User::class)->find($id);
        $createForm = $this->updateData($request,$data);
        if($createForm->isSubmitted() && $createForm->isValid()) {
            $this->dataConnection($createForm, $doctrine, $entityManager);
            $success=$this->successResponse();

            return new JsonResponse($success);
        }
        $failure = $this->failureResponse();

        return new JsonResponse($failure);  
    }
}
?>