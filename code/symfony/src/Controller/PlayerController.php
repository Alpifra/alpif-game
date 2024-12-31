<?php

namespace App\Controller;

use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlayerController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    #[Route('/player/{id}/increase', name: 'app_player_increase_score')]
    public function increase(Player $player): Response
    {
        $player->setScore($player->getScore() + 1);

        $this->entityManager->persist($player);
        $this->entityManager->flush();

        return $this->json('ok');
    }

    #[Route('/player/{id}/decrease', name: 'app_player_decrease_score')]
    public function decrease(Player $player): Response
    {
        $player->setScore($player->getScore() - 1);

        $this->entityManager->persist($player);
        $this->entityManager->flush();

        return $this->json('ok');
    }
}
