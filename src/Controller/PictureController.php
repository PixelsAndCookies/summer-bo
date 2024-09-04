<?php

namespace App\Controller;

use DateTime;
use App\Entity\Picture;
use App\Form\PictureType;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/picture')]
class PictureController extends AbstractController
{
    #[Route('/', name: 'picture.index', methods: ['GET'])]
    public function index(PictureRepository $pictureRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $pictureRepository->findOrderedByDate(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('picture/index.html.twig', [
            // 'pictures' => $pictureRepository->findOrderedByDate(),
            'pagination' => $pagination
        ]);
    }

    #[Route('/new', name: 'picture.new', methods: ['GET', 'POST'])]
    public function new(Request $request, 
    EntityManagerInterface $entityManager,
    #[Autowire('%kernel.project_dir%/public/imgs')] string $picturesDirectory
    ): Response
    {
        $picture = new Picture();
        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pictureFile = $form->get('file')->getData();
            if($pictureFile) {
                $date = $form->get('date')->getData() ?? date('Ymd');
                $newFilename = $date->format('Ymd') .'-'.uniqid() . "." . $pictureFile->guessExtension();

                try {
                    $pictureFile->move($picturesDirectory, $newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $picture->setFilename($newFilename);
            }
            $entityManager->persist($picture);
            $entityManager->flush();

            return $this->redirectToRoute('picture.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('picture/new.html.twig', [
            'picture' => $picture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'picture.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, 
    Picture $picture, 
    EntityManagerInterface $entityManager,
    #[Autowire('%kernel.project_dir%/public/imgs')] string $picturesDirectory): Response
    {
        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pictureFile = $form->get('file')->getData();
            if($pictureFile) {
                $date = $form->get('date')->getData() ?? date('Ymd');
                $newFilename = $date->format('Ymd') .'-'.uniqid() . "." . $pictureFile->guessExtension();
                $pictureFile->move($picturesDirectory, $newFilename);

                if($picture->getFilename()){
                    //supprimer l'ancien fichier
                    $oldFile = $picturesDirectory . "/" . $picture->getFilename();
                    if(file_exists($oldFile)){
                        unlink($oldFile);
                    }
                }

                $picture->setFilename($newFilename);
            }
            $entityManager->persist($picture);
            $entityManager->flush();

            return $this->redirectToRoute('picture.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('picture/edit.html.twig', [
            'picture' => $picture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'picture.delete', methods: ['POST'])]
    public function delete(Request $request, Picture $picture, EntityManagerInterface $entityManager,
    #[Autowire('%kernel.project_dir%/public/imgs')] string $picturesDirectory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$picture->getId(), $request->getPayload()->getString('_token'))) {
            $file = $picturesDirectory . "/" . $picture->getFilename();
            if(file_exists($file)){
                unlink($file);
            }
            $entityManager->remove($picture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('picture.index', [], Response::HTTP_SEE_OTHER);
    }
}
