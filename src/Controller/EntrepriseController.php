<?php

namespace App\Controller;

use App\Repository\RoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseController extends AbstractController
{
    /**
     * @Route("/entreprise", name="entreprise")
     */
    public function index(RoomsRepository $repo_room): Response
    {
        $rooms = $repo_room->findAll();
        return $this->render('pages/entreprise.html.twig', [
            'rooms' => $rooms
        ]);
    }
}
