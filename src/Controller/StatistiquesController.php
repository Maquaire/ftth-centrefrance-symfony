<?php

namespace App\Controller;

use App\Entity\Statistiques;
use App\Form\StatistiquesType;
use App\Repository\StatistiquesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/statistiques')]
class StatistiquesController extends AbstractController
{
    #[Route('/', name: 'app_statistiques_index', methods: ['GET'])]
    public function index(StatistiquesRepository $statistiquesRepository): Response
    {
        return $this->render('statistiques/index.html.twig', [
            'statistiques' => $statistiquesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_statistiques_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StatistiquesRepository $statistiquesRepository): Response
    {
        $statistique = new Statistiques();
        $form = $this->createForm(StatistiquesType::class, $statistique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $statistique->setCreatedAt(new \DateTimeImmutable());

            $statistiquesRepository->save($statistique, true);


            return $this->redirectToRoute('app_statistiques_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('statistiques/new.html.twig', [
            'statistique'       => $statistique,
            'allStatistiques'   => $statistiquesRepository->findAllOrderByCreatedAt(),
            'form'              => $form,
            'breadcrumb'        => 'Administration / Suivi des statistiques',
            'title'             => 'Suivi des statistiques'
        ]);
    }

    #[Route('/{id}', name: 'app_statistiques_show', methods: ['GET'])]
    public function show(Statistiques $statistique): Response
    {
        return $this->render('statistiques/show.html.twig', [
            'statistique' => $statistique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_statistiques_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Statistiques $statistique, StatistiquesRepository $statistiquesRepository): Response
    {
        $form = $this->createForm(StatistiquesType::class, $statistique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $statistiquesRepository->save($statistique, true);

            return $this->redirectToRoute('app_statistiques_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('statistiques/edit.html.twig', [
            'statistique' => $statistique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_statistiques_delete', methods: ['POST'])]
    public function delete(Request $request, Statistiques $statistique, StatistiquesRepository $statistiquesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$statistique->getId(), $request->request->get('_token'))) {
            $statistiquesRepository->remove($statistique, true);
        }

        return $this->redirectToRoute('app_statistiques_new', [], Response::HTTP_SEE_OTHER);
    }
}
