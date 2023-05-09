<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
 */
class Review
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(
     *  message="Votre nom d'utilisateur est obligatoire"
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *  message="Votre Email est obligatoire"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(
     *  message="Le contenu de votre critique est obligatoire"
     * )
     */
    private $content;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(
     *  message="Une note de 0 à 5 doit-être sélectionnée"
     * )
     */
    private $rating;

    /**
     * Doctrine utilise le type json pour stocker une valeur avec une structure complexe : Dans notre cas un tableau
     * @ORM\Column(type="json")
     * @Assert\NotBlank(
     *  message="Une réaction n'a pas été sélectionnée"
     * )
     */
    private $reactions = [];

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Assert\NotBlank(
     *  message="Quand avez-vous vu ce film?"
     * ) 
     */
    private $watchedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Movie::class)
     */
    private $movie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getReactions(): ?array
    {
        return $this->reactions;
    }

    public function setReactions(array $reactions): self
    {
        $this->reactions = $reactions;

        return $this;
    }

    public function getWatchedAt(): ?\DateTimeImmutable
    {
        return $this->watchedAt;
    }

    public function setWatchedAt(\DateTimeImmutable $watchedAt): self
    {
        $this->watchedAt = $watchedAt;

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