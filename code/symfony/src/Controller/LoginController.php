<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\PlayerCreateType;
use App\Form\PlayerJoinType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {}

    #[Route('/', name: 'app_login')]
    public function index(): Response
    {
        $formJoin = $this->createForm(PlayerJoinType::class);
        $formCreate = $this->createForm(PlayerCreateType::class);

        return $this->render('login.html.twig', [
            'formJoin'   => $formJoin,
            'formCreate' => $formCreate,
        ]);
    }

    #[Route('/join', name: 'app_join_session')]
    public function join(Request $request): Response
    {
        $form = $this->createForm(PlayerJoinType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $player = $form->getData();

            /** @var Session $session */
            $session = $form->get('session')->getData();
            $session->addPlayer($player);

            $this->entityManager->persist($player);
            $this->entityManager->persist($session);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_lobby');
        } else {

            return $this->redirectToRoute('app_login');
        }
    }

    #[Route('/create', name: 'app_create_session')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(PlayerCreateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $player = $form->getData();

            $session = new Session;
            $session->setHash(hash('crc32', time()));
            $session->addPlayer($player);

            $this->entityManager->persist($player);
            $this->entityManager->persist($session);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_lobby');
        } else {

            return $this->redirectToRoute('app_login');
        }
    }
}
