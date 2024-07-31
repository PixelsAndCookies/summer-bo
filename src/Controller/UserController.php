<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/utilisateurs')]
#[IsGranted('ROLE_USER')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user.index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'user.delete', methods: ['GET'])]
    public function delete(User $user, EntityManagerInterface $entityManager): Response
    {
        
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'L\'utilisateur a bien été supprimé.'
        );

        return $this->redirectToRoute('user.index', [], Response::HTTP_SEE_OTHER);
    }
}
