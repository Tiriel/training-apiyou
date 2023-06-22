<?php

namespace App\Search\Provider;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Search\OmdbMovieConsumer;
use App\Search\SearchTypeEnum;
use App\Search\Transformer\OmdbMovieTransformer;

class MovieProvider
{
    public function __construct(
        private readonly OmdbMovieConsumer $consumer,
        private readonly MovieRepository $repository,
        private readonly OmdbMovieTransformer $transformer,
        private readonly GenreProvider $genreProvider,
    ) {}

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
        $data = $this->consumer->fetchMovie($type, $value);

        if ($movie = $this->repository->findOneBy(['title' => $data['Title']])) {
            return $movie;
        }

        $movie = $this->transformer->transform($data);
        foreach ($this->genreProvider->getGenresFromOmdbString($data['Genre']) as $genre) {
            $movie->addGenre($genre);
        }

        $this->repository->save($movie, true);

        return $movie;
    }
}
