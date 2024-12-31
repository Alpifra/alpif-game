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

class LobbyController extends AbstractController
{
    public function __construct(
        private readonly PlayerRepository $playerRepository,
    ) {}

    #[Route('/lobby/{hash}', name: 'app_lobby')]
    public function index(
        #[MapEntity(class: Session::class, mapping: ['hash' => 'hash'])]
        Session $session,
        Request $request,
    ): Response {

        $currentUsername = $request->cookies->get('player');
        $currentPlayer = $this->playerRepository->findOneBy([
            'session'  => $session->getId(),
            'username' => $currentUsername
        ]);

        return $this->render('lobby.html.twig', [
            'players'       => $session->getPlayers(),
            'currentPlayer' => $currentPlayer,
        ]);
    }
}
