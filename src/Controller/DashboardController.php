<?php

namespace App\Controller;

use App\Repository\ActiviteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(ActiviteRepository $activiteRepository): Response
    {


        return $this->render('dashboard/dashboard.html.twig', [
            'activities' => $activiteRepository->findActivities(),
        ]);
    }
}
