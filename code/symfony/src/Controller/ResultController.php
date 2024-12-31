<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Session;
use App\Repository\PlayerRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ResultController extends AbstractController
{
    public function __construct(
        private readonly PlayerRepository $playerRepository,
    ) {}

    #[Route('/lobby/{hash}/leaderboard', name: 'app_leaderboard')]
    public function leaderboard(
        #[MapEntity(class: Session::class, mapping: ['hash' => 'hash'])]
        Session $session,
        Request $request,
    ): Response {

        $players = $session
        ->getPlayers()
        ->filter( fn(Player $p) => !$p->isMaster())
        ->getValues();

        usort(
            $players,
            fn(Player $a, Player $b) => $b->getScore() <=> $a->getScore()
        );

        $currentUsername = $request->cookies->get('player');
        $currentPlayer = $this->playerRepository->findOneBy([
            'session'  => $session->getId(),
            'username' => $currentUsername
        ]);

        return $this->render('leaderboard.html.twig', [
            'session'       => $session,
            'currentPlayer' => $currentPlayer,
            'players'       => $players,
        ]);
    }

    #[Route('/lobby/{hash}/result', name: 'app_result')]
    public function result(): Response
    {
        return $this->render('result.html.twig', [
            'controller_name' => 'ResultController',
        ]);
    }
}
