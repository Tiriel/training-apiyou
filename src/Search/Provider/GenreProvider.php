<?php

namespace App\Search\Provider;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use App\Search\Transformer\OmdbGenreTransformer;

class GenreProvider
{
    public function __construct(
        private readonly GenreRepository $repository,
        private readonly OmdbGenreTransformer $transformer
    ) {}

    public function getGenre(string $name): Genre
    {
        return $this->repository->findOneBy(['name' => $name])
            ?? $this->transformer->transform($name);
    }

    public function getGenresFromOmdbString(string $genres): \Generator
    {
        foreach (explode(', ', $genres) as $name) {
            yield $this->getGenre($name);
        }
    }
}
