<?php

namespace App\Controller;

use App\Dto\Song;
use App\Form\SongType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SongController extends AbstractController
{
    #[Route('/song', name: 'app_song')]
    public function index(): Response
    {
        return $this->render('song/index.html.twig', [
            'controller_name' => 'SongController',
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/song/new', name: 'app_song_new')]
    public function new(Request $request): Response
    {
        $dto = new Song();
        $form = $this->createForm(SongType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($dto);

            return $this->redirectToRoute('app_song_new');
        }

        return $this->render('song/new.html.twig', [
            'form' => $form,
        ]);
    }
}
