<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardType;
use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/card')]
#[IsGranted('ROLE_USER')]
class CardController extends AbstractController
{
    #[Route('/', name: 'card.index', methods: ['GET'])]
    public function index(CardRepository $cardRepository): Response
    {
        return $this->render('card/index.html.twig', [
            'cards' => $cardRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'card.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $card = new Card();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($card);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'L\'élément a bien été créé'
            );

            return $this->redirectToRoute('card.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('card/new.html.twig', [
            'card' => $card,
            'form' => $form,
            'button_label'=> 'Ajouter'
        ]);
    }


    #[Route('/{id}/edit', name: 'card.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Card $card, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'success',
                'L\'élément a bien été modifié'
            );

            return $this->redirectToRoute('card.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('card/edit.html.twig', [
            'card' => $card,
            'form' => $form,
            'button_label'=> 'Modifier'
        ]);
    }

    #[Route('/{id}', name: 'card.delete', methods: ['GET'])]
    public function delete(Request $request, Card $card, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($card);
        $entityManager->flush();
        
        $this->addFlash(
            'success',
            'L\'élément a bien été supprimé.'
        );
        
        return $this->redirectToRoute('Card.index', [], Response::HTTP_SEE_OTHER);
    }
}
