<?php

namespace App\Controller;

use ContainerECFo1Ox\getResponseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

Class HelloPage extends AbstractController
{
    #[Route('/hello', name: 'hello',)]
    public function welcome(): Response
    {
        $message = 'hi lamp';
        return new response($message);
    }
}

