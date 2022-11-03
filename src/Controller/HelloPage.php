<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

Class HelloPage extends AbstractController
{
    #[Route('/hello', name: 'hello',)]
    public function welcome(): Response
    {
        $message = 'HI';
        return new response($message);
    }
}

