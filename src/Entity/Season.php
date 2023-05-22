<?php

namespace App\Entity;

use App\Repository\SeasonRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SeasonRepository::class)
 */
class Season
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"movie_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"movie_read"})
     */
    private $number;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"movie_read"})
     */
    private $nbEpisodes;

    /**
     * @ORM\ManyToOne(targetEntity=Movie::class, inversedBy="seasons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getNbEpisodes(): ?int
    {
        return $this->nbEpisodes;
    }

    public function setNbEpisodes(int $nbEpisodes): self
    {
        $this->nbEpisodes = $nbEpisodes;

        return $this;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }
}
