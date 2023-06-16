<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getMovies() as $movie) {
            $manager->persist($movie);
        }

        $manager->flush();
    }

    public function getMovies(): iterable
    {
        foreach ($this->getMoviesData() as $datum) {
            $date = $datum['Released'] === 'N/A' ? $datum['Year'] : $datum['Released'];

            $movie = (new Movie())
                ->setTitle($datum['Title'])
                ->setPlot($datum['Plot'])
                ->setCountry($datum['Country'])
                ->setReleasedAt(new \DateTimeImmutable($date))
                ->setDirectors($datum['Director'])
                ->setWriters($datum['Writer'])
                ->setActors($datum['Actors'])
                ->setRated($datum['Rated'])
                ->setImdbId($datum['imdbID'])
                ->setPoster($datum['Poster'])
                ->setPrice(5.0)
            ;

            foreach (explode(', ', $datum['Genre']) as $genreName) {
                $movie->addGenre((new Genre())->setName($genreName));
            }

            yield $movie;
        }
    }

    public function getMoviesData(): iterable
    {
        $files = (new Finder())
            ->in(__DIR__)
            ->files()
            ->name('movie_fixtures.json');

        foreach ($files as $file) {
            $content = $file->getContents();

            foreach (\json_decode($content, true) as $item) {
                yield $item;
            }
        }
    }
}
