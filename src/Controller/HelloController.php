<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello/{name<(\p{L}|[- ])+>}', name: 'app_hello', defaults: ['name' => 'World'])]
    public function index(string $name, #[Autowire('%app.sf_version%')] string $sfVersion): Response
    {
        dump($sfVersion);

        return $this->render('hello/index.html.twig', [
            'controller_name' => $name,
        ]);
    }
}
