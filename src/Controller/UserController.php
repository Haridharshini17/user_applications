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
use App\Service\UserService;

class UserController extends AbstractController
{
    public function __construct(BaseController $baseController)
    {
        $this->baseController = $baseController;
    }

   #[Route('user/add', name: 'add', methods: ['POST'])]
   public function insert(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
   { 
        $createForm = $this->baseController->insertData($request,$doctrine,$entityManager);
        if($createForm->isSubmitted() && $createForm->isValid()) {
            $this->baseController->dataConnection($createForm,$doctrine,$entityManager);
            $success=$this->baseController->successResponse();
            return new JsonResponse($success);
        }
        $failure = $this->baseController->failureResponse();
        return new JsonResponse($failure);  
   }

   #[Route('user/display/{id}', name: 'display', methods: ['GET'])]
   public function display(ManagerRegistry $doctrine, $id): Response
   {
        $displayData = new UserService();
        $datas= $displayData->displayData($doctrine, $id);
        return new Response($this->json($datas));
   }

   #[Route('user/delete/{id}', name: 'delete', methods: ['DELETE'])]
   public function delete(ManagerRegistry $doctrine, $id): Response
   {
        $deleteData = $doctrine->getManager();
        $record = $doctrine->getRepository(User::class)->find($id);
        if($record) {
		    $deleteData->remove($record);
            $deleteData->flush();
            $success=$this->baseController->successResponse();
            return new JsonResponse($success);
        }
        $failure = $this->baseController->failureResponse();
        return new JsonResponse($failure);
   }

   #[Route('user/update/{id}', name: 'update', methods: ['PATCH'])]
   public function update(ManagerRegistry $doctrine ,$id, Request $request, EntityManagerInterface $entityManager): Response
   {
        $createForm = $this->baseController->updateData($doctrine,$id,$request);
        if($createForm->isSubmitted() && $createForm->isValid()) {
            $this->baseController->dataConnection($createForm,$doctrine,$entityManager);
            $success=$this->baseController->successResponse();
            return new JsonResponse($success);
        }
        $failure = $this->baseController->failureResponse();
        return new JsonResponse($failure);  
    }
}
?>