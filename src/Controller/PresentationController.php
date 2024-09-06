<?php

namespace App\Controller;

use App\Entity\Presentation;
use App\Form\PresentationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/presentation')]
#[IsGranted('ROLE_USER')]
class PresentationController extends AbstractController
{

    #[Route('/{id}/edit', name: 'presentation.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Presentation $presentation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PresentationType::class, $presentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'success',
                'La présentation a bien été modifiée'
            );
            return $this->redirectToRoute('presentation.edit', ['id'=>1], Response::HTTP_SEE_OTHER);
        }

        return $this->render('presentation/edit.html.twig', [
            'presentation' => $presentation,
            'form' => $form,
        ]);
    }
}
