<?php

namespace App\Search\Transformer;

use App\Entity\Movie;
use Symfony\Component\Form\DataTransformerInterface;

class OmdbMovieTransformer implements DataTransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform(mixed $value)
    {
        $date = $value['Released'] === 'N/A' ? '01-01-'.$value['Year'] : $value['Released'];

        return (new Movie())
            ->setTitle($value['Title'])
            ->setPoster($value['Poster'])
            ->setPlot($value['Plot'])
            ->setReleasedAt(new \DateTimeImmutable($date))
            ->setCountry($value['Country'])
            ->setPrice(500)
            ;
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform(mixed $value)
    {
        throw new \RuntimeException("Not implemented.");
    }
}
