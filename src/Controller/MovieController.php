<?php

namespace App\Controller;

use App\Consumer\OmdbApiConsumer;
use App\Entity\Movie;
use App\Form\MovieType;
use App\Payment\PaymentFactory;
use App\Provider\MovieProvider;
use App\Repository\MovieRepository;
use App\Search\OmdbMovieConsumer;
use App\Search\SearchTypeEnum;
use App\Search\Transformer\OmdbMovieTransformer;
use App\Security\Voter\MovieVoter;
use App\Transformer\OmdbToMovieTransformer;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/new', name: 'app_movie_new', methods: ['GET', 'POST'])]
    #[Route('/{id<\d+>}/edit', name: 'app_movie_edit', methods: ['GET', 'POST'])]
    public function save(Request $request, MovieRepository $repository, ?Movie $movie = null)
    {
        $movie ??= new Movie();
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($movie, true);

            return $this->redirectToRoute('app_movie_show', ['id' => $movie->getId()]);
        }

        return $this->render('movie/save.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/omdb/{title}', name: 'app_movie_omdb', methods: ['GET'])]
    public function omdb(string $title, OmdbMovieConsumer $consumer, OmdbMovieTransformer $transformer): Response
    {
        $movie = $transformer->transform($consumer->fetchMovie(SearchTypeEnum::TITLE, $title));

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }
}
