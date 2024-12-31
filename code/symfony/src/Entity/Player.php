<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Config\AvatarEnum;
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

    #[ORM\Column(enumType: AvatarEnum::class)]
    private AvatarEnum $avatar;

    #[ORM\ManyToOne(inversedBy: 'players')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Session $session = null;

    #[ORM\Column(options: ['default' => false])]
    private bool $master = false;

    #[ORM\Column(options: ['default' => 0])]
    private int $score = 0;

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

    public function getAvatar(): AvatarEnum
    {
        return $this->avatar;
    }

    public function setAvatar(AvatarEnum $avatar): static
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

    public function isMaster(): bool
    {
        return $this->master;
    }

    public function setMaster(bool $master): static
    {
        $this->master = $master;

        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }
}
