<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class MainController extends AbstractController
{
    #[Route('', name: 'app_admin_main_index')]
    public function index(): Response
    {
        return $this->render('admin/main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/me/{!name<[^\d]+>}', name: 'app_admin_main_me', defaults: ['name' => 'Ben'], methods: ['GET'])]
    public function me(string $name): Response
    {
        return $this->render('admin/main/index.html.twig', [
            'controller_name' => $name,
        ]);
    }
}
