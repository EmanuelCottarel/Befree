<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Personnels;
use App\Repository\ActiviteRepository;
use App\Repository\PersonnelsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class CalendrierController extends AbstractController
{
    #[Route('/calendrier', name: 'app_calendrier')]
    public function show(ActiviteRepository $activiteRepository, PersonnelsRepository $personnelsRepository, UserInterface $user): Response
    {
        $activites = $activiteRepository->findActivities();
        $accompagnateurs = [];
        foreach ($activites as $activite) {
            $accompagnateurs[] = ['activiteId' => $activite->getId(), 'accompagnateur' => $personnelsRepository->findPersonnelsForOneActivity($activite->getId())];
        }


        return $this->render('calendrier/calendrier.html.twig', [
            'activitesAccompagnateurs' => $activiteRepository->findActivitiesForPersonnel($user->getId()),
            'activites' => $activiteRepository->findActivities(),
            'personnelActivite' => $personnelsRepository->findPersonnelsForOneActivity(8),
            'accompagnateurs' => $accompagnateurs,
            'personnels' => $personnelsRepository->findAllPersonnels(),


        ]);
    }
}
