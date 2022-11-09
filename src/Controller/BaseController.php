<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
}