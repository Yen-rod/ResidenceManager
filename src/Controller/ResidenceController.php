<?php

namespace App\Controller;

use App\Entity\Residence;
use App\Form\ResidenceType;
use App\Repository\ResidenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/residence')]
class ResidenceController extends AbstractController
{
    #[Route('/', name: 'app_residence_index', methods: ['GET'])]
    public function index(ResidenceRepository $residenceRepository): Response
    {
        return $this->render('residence/index.html.twig', [
            'residences' => $residenceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_residence_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $residence = new Residence();
        $form = $this->createForm(ResidenceType::class, $residence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($residence);
            $entityManager->flush();

            return $this->redirectToRoute('app_residence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('residence/new.html.twig', [
            'residence' => $residence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_residence_show', methods: ['GET'])]
    public function show(Residence $residence): Response
    {
        return $this->render('residence/show.html.twig', [
            'residence' => $residence,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_residence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Residence $residence, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ResidenceType::class, $residence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_residence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('residence/edit.html.twig', [
            'residence' => $residence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_residence_delete', methods: ['POST'])]
    public function delete(Request $request, Residence $residence, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$residence->getId(), $request->request->get('_token'))) {
            $entityManager->remove($residence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_residence_index', [], Response::HTTP_SEE_OTHER);
    }
}
