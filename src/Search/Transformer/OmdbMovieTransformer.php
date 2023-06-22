<?php

namespace App\Search\Transformer;

use App\Entity\Movie;
use Symfony\Component\Form\DataTransformerInterface;

class OmdbMovieTransformer implements DataTransformerInterface
{
    public function __construct(
        private readonly OmdbGenreTransformer $transformer,
    ) {}

    /**
     * @inheritDoc
     */
    public function transform(mixed $value)
    {
        $date = $value['Released'] === 'N/A' ? '01-01-'.$value['Year'] : $value['Released'];

        $movie = (new Movie())
            ->setTitle($value['Title'])
            ->setPoster($value['Poster'])
            ->setPlot($value['Plot'])
            ->setReleasedAt(new \DateTimeImmutable($date))
            ->setCountry($value['Country'])
            ->setPrice(500)
            ;

        foreach (explode(', ', $value['Genre']) as $name) {
            $movie->addGenre($this->transformer->transform($name));
        }

        return $movie;
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform(mixed $value)
    {
        throw new \RuntimeException("Not implemented.");
    }
}
