<?php

namespace App\Controller;

use App\Consumer\OmdbApiConsumer;
use App\Payment\PaymentFactory;
use App\Provider\MovieProvider;
use App\Repository\MovieRepository;
use App\Security\Voter\MovieVoter;
use App\Transformer\OmdbToMovieTransformer;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//#[IsGranted('ROLE_MODERATOR')]
#[Route('/movie')]
class MovieController extends AbstractController
{
    #[Route('', name: 'app_movie_index')]
    public function index(MovieRepository $repository): Response
    {
        return $this->render('movie/index.html.twig', [
            'movies' => $repository->findAll(),
        ]);
    }

    #[Route('/{id<\d+>}', name: 'app_movie_show')]
    public function show(int $id, MovieRepository $repository): Response
    {
        $movie = $repository->find($id);

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }
}
