<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Assert\NotBlank]
    #[Assert\Url]
    #[ORM\Column(length: 255)]
    private ?string $poster = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $plot = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $releasedAt = null;

    #[Assert\Country]
    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[Assert\LessThan(1000)]
    #[ORM\Column(nullable: true)]
    private ?int $price = null;

    #[Assert\Unique]
    #[Assert\Valid]
    #[ORM\ManyToMany(targetEntity: Genre::class, cascade: ['persist'])]
    private Collection $genre;

    #[ORM\Column(length: 255)]
    private ?string $imdbId = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $rated = null;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    private ?User $createdBy = null;

    public function __construct()
    {
        $this->genre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): static
    {
        $this->poster = $poster;

        return $this;
    }

    public function getPlot(): ?string
    {
        return $this->plot;
    }

    public function setPlot(string $plot): static
    {
        $this->plot = $plot;

        return $this;
    }

    public function getReleasedAt(): ?\DateTimeImmutable
    {
        return $this->releasedAt;
    }

    public function setReleasedAt(\DateTimeImmutable $releasedAt): static
    {
        $this->releasedAt = $releasedAt;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getGenre(): string
    {
        return implode(', ', array_map(
            fn(Genre $genre) => $genre->getName(),
            $this->genre->toArray()
        ));
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genre;
    }

    public function addGenre(Genre $genre): static
    {
        if (!$this->genre->contains($genre)) {
            $this->genre->add($genre);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): static
    {
        $this->genre->removeElement($genre);

        return $this;
    }

    public function getImdbId(): ?string
    {
        return $this->imdbId;
    }

    public function setImdbId(string $imdbId): static
    {
        $this->imdbId = $imdbId;

        return $this;
    }

    public function getRated(): ?string
    {
        return $this->rated;
    }

    public function setRated(?string $rated): static
    {
        $this->rated = $rated;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
