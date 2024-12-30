<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Session;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LobbyController extends AbstractController
{
    #[Route('/lobby/{hash}/{username}', name: 'app_lobby')]
    public function index(
        #[MapEntity(class: Session::class, mapping: ['hash' => 'hash'])]
        Session $session,
        #[MapEntity(class: Player::class, mapping: ['username' => 'username'])]
        Player $currentPlayer,
    ): Response {

        return $this->render('lobby.html.twig', [
            'players'       => $session->getPlayers(),
            'currentPlayer' => $currentPlayer,
        ]);
    }
}
