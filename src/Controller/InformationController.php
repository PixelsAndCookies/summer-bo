<?php

namespace App\Controller;

use App\Entity\Information;
use App\Form\InformationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InformationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/information')]
#[IsGranted('ROLE_USER')]
class InformationController extends AbstractController
{
    #[Route('/', name: 'information.index', methods: ['GET'])]
    public function index(InformationRepository $informationRepository): Response
    {
        return $this->render('information/index.html.twig', [
            'information' => $informationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'information.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $information = new Information();
        $form = $this->createForm(InformationType::class, $information);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($information);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'L\'information a bien été ajoutée'
            );

            return $this->redirectToRoute('information.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('information/new.html.twig', [
            'information' => $information,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'information.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Information $information, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InformationType::class, $information);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'success',
                'L\'information a bien été modifiée'
            );
            return $this->redirectToRoute('information.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('information/edit.html.twig', [
            'information' => $information,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'information.delete', methods: ['GET'])]
    public function delete(Request $request, Information $information, EntityManagerInterface $entityManager): Response
    {
       
        $entityManager->remove($information);
        $entityManager->flush();
        
        $this->addFlash(
            'success',
            'L\'information a bien été supprimée'
        );

        return $this->redirectToRoute('information.index', [], Response::HTTP_SEE_OTHER);
    }
}
