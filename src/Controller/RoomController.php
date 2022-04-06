<?php

namespace App\Controller;

use App\Entity\Rooms;
use App\Repository\RoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    /**
     * @Route("/salle/{id}", name="room")
     */
    public function index(RoomsRepository $repo_room, Rooms $thisRoom): Response
    {
        $rooms = $repo_room->findAll();
        return $this->render('pages/room.html.twig', [
            'rooms' => $rooms,
            'thisRoom' => $thisRoom
        ]);
    }
}
