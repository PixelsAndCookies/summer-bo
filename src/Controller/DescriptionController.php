<?php

namespace App\Controller;

use App\Entity\Description;
use App\Form\DescriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/description')]
#[IsGranted('ROLE_USER')]
class DescriptionController extends AbstractController
{

    #[Route('/{id}/edit', name: 'description.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Description $description, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DescriptionType::class, $description);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'success',
                'La description a bien été modifiée'
            );
            return $this->redirectToRoute('description.edit', ['id'=>1], Response::HTTP_SEE_OTHER);
        }

        return $this->render('description/edit.html.twig', [
            'description' => $description,
            'form' => $form,
        ]);
    }
}
