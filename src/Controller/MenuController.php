<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/menu')]
#[IsGranted('ROLE_USER')]
class MenuController extends AbstractController
{
    #[Route('/', name: 'menu.index', methods: ['GET'])]
    public function index(MenuRepository $menuRepository): Response
    {
        return $this->render('menu/index.html.twig', [
            'menus' => $menuRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'menu.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($menu);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'L\'élément a bien été créé'
            );

            return $this->redirectToRoute('menu.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('menu/new.html.twig', [
            'menu' => $menu,
            'form' => $form,
            'button_label'=> 'Ajouter'
        ]);
    }


    #[Route('/{id}/edit', name: 'menu.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Menu $menu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'success',
                'L\'élément a bien été modifié'
            );

            return $this->redirectToRoute('menu.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('menu/edit.html.twig', [
            'menu' => $menu,
            'form' => $form,
            'button_label'=> 'Modifier'
        ]);
    }

    #[Route('/{id}', name: 'menu.delete', methods: ['GET'])]
    public function delete(Request $request, Menu $menu, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($menu);
        $entityManager->flush();
        
        $this->addFlash(
            'success',
            'L\'élément a bien été supprimé.'
        );
        
        return $this->redirectToRoute('menu.index', [], Response::HTTP_SEE_OTHER);
    }
}
