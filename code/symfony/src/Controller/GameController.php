<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Session;
use App\Repository\PlayerRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GameController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly QuestionRepository $questionRepository,
        private readonly PlayerRepository $playerRepository,
    ) {}

    #[Route('/lobby/{hash}/question', name: 'app_question')]
    public function index(
        #[MapEntity(class: Session::class, mapping: ['hash' => 'hash'])]
        Session $session,
        Request $request,
        int $position = 0,
    ): Response {

        $question = $this->questionRepository->findOneByPosition($position);

        if (!$question) {
            return $this->redirectToRoute('app_leaderboard', ['hash' => $session->getHash()]);
        }

        $currentUsername = $request->cookies->get('player');
        $currentPlayer = $this->playerRepository->findOneBy([
            'session'  => $session->getId(),
            'username' => $currentUsername
        ]);

        $players = $session
            ->getPlayers()
            ->filter( fn(Player $p) => !$p->isMaster())
            ->getValues();

        usort(
            $players,
            fn(Player $a, Player $b) => $b->getScore() <=> $a->getScore()
        );

        return $this->render('question.html.twig', [
            'session'       => $session,
            'question'      => $question,
            'currentPlayer' => $currentPlayer,
            'players'       => $players,
        ]);
    }

    #[Route('/lobby/{hash}/next', name: 'app_next_question')]
    public function next(
        #[MapEntity(class: Session::class, mapping: ['hash' => 'hash'])]
        Session $session,
        Request $request,
    ): Response {

        $question = $this->questionRepository->find($request->get('question'));
        $answers = $question->getAnswers();
        $answer = $request->get('answer');
        $valid = false;

        foreach ($answers as $a) {
            if ($a['answer'] === $answer) {
                if ($a['valid']) $valid = true;;
                break;
            }
        }

        if ($valid) {
            $player = $this->playerRepository->find($request->get('player'));
            $player->setScore($player->getScore() + 1);

            $this->entityManager->persist($player);
            $this->entityManager->flush();
        }

        return $this->index($session, $request, $question->getPosition());
    }
}
