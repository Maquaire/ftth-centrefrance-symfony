<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {       
        return $this->render('base.html.twig', [
            'title' => "Tableau de bord",
            'breadcrumb' => "Tableau de bord",
        ]);
    }
}
