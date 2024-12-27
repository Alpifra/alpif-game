<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Config\QuestionEnum;
use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ApiResource]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: QuestionEnum::class)]
    private QuestionEnum $type;

    #[ORM\Column]
    private int $position;

    #[ORM\Column]
    private array $content = [];

    #[ORM\Column]
    private array $answers = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): QuestionEnum
    {
        return $this->type;
    }

    public function setType(QuestionEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function setContent(array $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getAnswers(): array
    {
        return $this->answers;
    }

    public function setAnswers(array $answers): static
    {
        $this->answers = $answers;

        return $this;
    }
}
