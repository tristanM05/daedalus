<?php

namespace App\Controller;

use App\Entity\Rooms;
use App\Repository\ChildGameRepository;
use App\Repository\MobileRepository;
use App\Repository\RoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    /**
     * @Route("/salle/{id}", name="room")
     */
    public function index(RoomsRepository $repo_room, Rooms $thisRoom, ChildGameRepository $repo_child, MobileRepository $mobiles_repo): Response
    {
        $rooms = $repo_room->findAll();
        $childs = $repo_child->findAll();
        $mobiles = $mobiles_repo->findAll();
        return $this->render('pages/room.html.twig', [
            'rooms' => $rooms,
            'thisRoom' => $thisRoom,
            'childs' => $childs,
            'mobiles' => $mobiles
        ]);
    }
}
