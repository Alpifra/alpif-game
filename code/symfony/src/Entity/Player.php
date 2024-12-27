<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Config\AvatarType;
use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
#[ApiResource]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private string $username;

    #[ORM\Column(enumType: AvatarType::class)]
    private AvatarType $avatar;

    #[ORM\ManyToOne(inversedBy: 'players')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Session $session = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getAvatar(): AvatarType
    {
        return $this->avatar;
    }

    public function setAvatar(AvatarType $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getSession(): Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): static
    {
        $this->session = $session;

        return $this;
    }
}
