<?php

namespace App\Search\Provider;

use App\Entity\Movie;
use App\Entity\User;
use App\Repository\MovieRepository;
use App\Search\OmdbMovieConsumer;
use App\Search\SearchTypeEnum;
use App\Search\Transformer\OmdbMovieTransformer;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Console\Style\SymfonyStyle;

class MovieProvider
{
    private ?SymfonyStyle $io = null;
    public function __construct(
        private readonly OmdbMovieConsumer $consumer,
        private readonly MovieRepository $repository,
        private readonly OmdbMovieTransformer $transformer,
        private readonly GenreProvider $genreProvider,
        private readonly Security $security,
    ) {}

    public function setIo(?SymfonyStyle $io): void
    {
        $this->io = $io;
    }

    public function getMovieByTitle(string $title): Movie
    {
        return $this->getMovie(SearchTypeEnum::TITLE, $title);
    }

    public function getMovieById(string $id): Movie
    {
        return $this->getMovie(SearchTypeEnum::ID, $id);
    }

    public function getMovie(SearchTypeEnum $type, string $value): Movie
    {
        $this->io?->text('Checking on OMDb API...');
        $data = $this->consumer->fetchMovie($type, $value);
        $this->io?->text('Movie found!');

        if ($movie = $this->repository->findOneBy(['title' => $data['Title']])) {
            $this->io?->note('Movie already in Database!');
            return $movie;
        }

        $movie = $this->transformer->transform($data);
        foreach ($this->genreProvider->getGenresFromOmdbString($data['Genre']) as $genre) {
            $movie->addGenre($genre);
        }

        if (($user = $this->security->getUser()) instanceof User) {
            $movie->setCreatedBy($user);
        }

        $this->io?->text('Saving movie in database.');
        $this->repository->save($movie, true);

        return $movie;
    }
}
