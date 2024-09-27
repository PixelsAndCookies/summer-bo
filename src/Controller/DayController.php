<?php

namespace App\Controller;

use App\Entity\Day;
use App\Form\DayType;
use App\Entity\Content;
use App\Entity\DayPicture;
use App\Repository\DayRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/day')]
final class DayController extends AbstractController
{
    #[Route(name: 'day.index', methods: ['GET'])]
    public function index(DayRepository $dayRepository): Response
    {
        return $this->render('day/index.html.twig', [
            'days' => $dayRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'day.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ?int $template = 1): Response
    {
        $day = new Day();

        switch($template){
            case 1 :
                $nbContents = 2;
                $nbPictures = 7;
                break;
            case 2 :
                $nbContents = 2;
                $nbPictures = 6;
                break;
            case 3 :
                $nbContents = 3;
                $nbPictures = 6;
                break;
            case 4 :
                $nbContents = 4;
                $nbPictures = 9;
                break;
            case 5 :
                $nbContents = 1;
                $nbPictures = 11;
                break;
            case 6 :
                $nbContents = 3;
                $nbPictures = 8;
                break;
            case 7 :
                $nbContents = 4;
                $nbPictures = 5;
                break;
            case 8 :
                $nbContents = 3;
                $nbPictures = 10;
                break;
            case 9 :
                $nbContents = 2;
                $nbPictures = 7;
                break;
            case 10 :
                $nbContents = 2;
                $nbPictures = 6;
                break;
            default:
                $nbContents = 1;
                $nbPictures = 1;
                break;
        }

        for($i = 0; $i < $nbContents; $i++){
            $day->addContent(new Content());
        }


        $form = $this->createForm(DayType::class, $day);
 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($day);
            $entityManager->flush();

            return $this->redirectToRoute('day.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('day/new.html.twig', [
            'day' => $day,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'day.show', methods: ['GET'])]
    public function show(Day $day): Response
    {
        return $this->render('day/show.html.twig', [
            'day' => $day,
        ]);
    }

    #[Route('/{id}/edit', name: 'day.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Day $day, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DayType::class, $day);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('day.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('day/edit.html.twig', [
            'day' => $day,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'day.delete', methods: ['POST'])]
    public function delete(Request $request, Day $day, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$day->getIdDay(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($day);
            $entityManager->flush();
        }

        return $this->redirectToRoute('day.index', [], Response::HTTP_SEE_OTHER);
    }
}
