<?php

namespace App\Controller;

use App\Entity\Actu;
use App\Repository\ActuRepository;
use App\Repository\ChildGameRepository;
use App\Repository\MobileRepository;
use App\Repository\RoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActuController extends AbstractController
{
    /**
     * @Route("/actualités", name="allActu")
     */
    public function index(ActuRepository $repo_actu, RoomsRepository $repo_room, ChildGameRepository $repo_child, MobileRepository $mobiles_repo): Response
    {
        $rooms = $repo_room->findAll();
        $allActu = $repo_actu->findBy([], ['createdAt' => 'DESC']);
        $childs = $repo_child->findAll();
        $mobiles = $mobiles_repo->findAll();

        return $this->render('pages/allActu.html.twig', [
            'actu' => $allActu,
            'rooms' => $rooms,
            'childs' => $childs,
            'mobiles' => $mobiles
        ]);
    }

    /**
     * @Route("/actualités/{id}", name="actu")
     */
    public function showActu(Actu $actu, RoomsRepository $repo_room, ChildGameRepository $repo_child, MobileRepository $mobiles_repo){

        $rooms = $repo_room->findAll();
        $childs = $repo_child->findAll();
        $mobiles = $mobiles_repo->findAll();

        return $this->render('pages/showActu.html.twig', [
            'actu' => $actu,
            'rooms' => $rooms,
            'childs' => $childs,
            'mobiles' => $mobiles
        ]);
    }
}
