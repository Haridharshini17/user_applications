<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\PhoneNumber;
use App\Form\Type\UserRecordsForm;

class BaseController extends AbstractController
{
    #[Route('/', name: 'home',)]
    public function welcome(): Response
    {
        $message = 'HI';
        return new response($message);
    }

    public function successResponse()
    {
        return $success = [
            'message' => 'Operation completed successfully!'
        ];
    }

    public function failureResponse()
    {
        return $failure = [
            'message' => 'Operation Failed, Please check the datas'
        ];
    }

    public function dataConnection($createForm, ManagerRegistry $doctrine, EntityManagerInterface $entityManager) 
    {
        $user = $createForm->getData();
        $entityManager = $doctrine->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
    }

    public function insertData(Request $request)
    {
        $user = new User;
        $phoneNumber = new PhoneNumber;
        $phoneNumber = $user->addPhoneNumber($phoneNumber);
        $createForm = $this->createForm(UserRecordsForm::class, $user);
        $createForm->handleRequest($request);
        $createForm->submit(json_decode($request->getContent(), true));
        return $createForm;
    }

    public function updateData(ManagerRegistry $doctrine, $id, Request $request)
    {
        $user = new User();
        $entityManager = $doctrine->getManager();
        $data = $entityManager->getRepository(User::class)->find($id);
        $createForm = $this->createForm(UserRecordsForm::class, $data);
        $createForm->handleRequest($request);
        $data = $createForm->getData();
        $createForm->submit(json_decode($request->getContent(), true));
        return $createForm;
    } 
}
?>