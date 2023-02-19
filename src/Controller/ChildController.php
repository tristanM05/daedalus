<?php

namespace App\Controller;

use App\Entity\ChildGame;
use App\Repository\ChildGameRepository;
use App\Repository\MobileRepository;
use App\Repository\RoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChildController extends AbstractController
{
    /**
     * @Route("/child/{id}", name="child")
     */
    public function index(RoomsRepository $repo_room, ChildGame $thisChild, ChildGameRepository $repo_child, MobileRepository $mobiles_repo): Response
    {
        $rooms = $repo_room->findAll();
        $childs = $repo_child->findAll();
        $mobiles = $mobiles_repo->findAll();

        return $this->render('pages/child.html.twig', [
            'rooms' => $rooms,
            'thisChild' => $thisChild,
            'childs' => $childs,
            'mobiles' => $mobiles
        ]);
    }
}
