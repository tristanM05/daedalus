<?php

namespace App\Controller;

use App\Entity\Actu;
use App\Repository\ActuRepository;
use App\Repository\RoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActuController extends AbstractController
{
    /**
     * @Route("/actualités", name="allActu")
     */
    public function index(ActuRepository $repo_actu, RoomsRepository $repo_room): Response
    {
        $rooms = $repo_room->findAll();
        $allActu = $repo_actu->findBy([], ['createdAt' => 'DESC']);

        return $this->render('pages/allActu.html.twig', [
            'actu' => $allActu,
            'rooms' => $rooms
        ]);
    }

    /**
     * @Route("/actualités/{id}", name="actu")
     */
    public function showActu(Actu $actu, RoomsRepository $repo_room){

        $rooms = $repo_room->findAll();

        return $this->render('pages/showActu.html.twig', [
            'actu' => $actu,
            'rooms' => $rooms
        ]);
    }
}
