<?php
declare(strict_types = 1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/main', name: 'main')]
    public function getData(): JsonResponse
    {
        return new JsonResponse(
            'firstEndpoint',
        );
    }
}
