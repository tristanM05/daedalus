<?php

namespace App\Controller;

use App\Repository\RoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TarifController extends AbstractController
{
    /**
     * @Route("/tarif", name="tarif")
     */
    public function index(RoomsRepository $repo_room): Response
    {
        $rooms = $repo_room->findAll();
        return $this->render('pages/tarif.html.twig', [
            'rooms' => $rooms
        ]);
    }
}
