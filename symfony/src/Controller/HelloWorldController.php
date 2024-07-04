<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class HelloWorldController extends AbstractController
{
    public function hello(): JsonResponse
    {
        return new JsonResponse(['message' => 'Hello World']);
    }
}

