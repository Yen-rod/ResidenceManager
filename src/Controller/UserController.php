<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\Users1Type;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// #[Route('/get/user')]
class UserController extends AbstractController

{
    private $usersRepository;
    public function __construct(UsersRepository $usersRepository) {
        $this->usersRepository = $usersRepository;
    }

    #[Route('/usuarios', name: 'app_get_user_index', methods: ['GET'])]
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('get_user/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_get_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new Users();
        $form = $this->createForm(Users1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_get_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('get_user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_get_user_show', methods: ['GET'])]
    public function show(Users $user): Response
    {
        return $this->render('get_user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_get_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Users1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_get_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('get_user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_get_user_delete', methods: ['POST'])]
    public function delete(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush($user);
        }

        return $this->redirectToRoute('app_get_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
