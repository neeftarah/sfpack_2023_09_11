<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello/{name<\w([-\w]*)>}', name: 'app_hello', methods: ['GET'])]
    public function index(string $name = "whoever you are"): Response
    {
        return new Response(<<<"HTML"
        <body>
            Hello $name
        </body>
        HTML);
    }
}
