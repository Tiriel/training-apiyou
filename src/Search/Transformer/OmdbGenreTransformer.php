<?php

namespace App\Search\Transformer;

use App\Entity\Genre;

class OmdbGenreTransformer implements \Symfony\Component\Form\DataTransformerInterface
{

    /**
     * @inheritDoc
     */
    public function transform(mixed $value)
    {
        if (!\is_string($value) || str_contains($value, ',')){
            throw new \InvalidArgumentException();
        }

        return (new Genre())->setName($value);
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform(mixed $value)
    {
        throw new \RuntimeException("Not implemented.");
    }
}
