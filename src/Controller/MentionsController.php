<?php

namespace App\Controller;

use App\Repository\ChildGameRepository;
use App\Repository\MobileRepository;
use App\Repository\RoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MentionsController extends AbstractController
{
    /**
     * @Route("/mentions", name="mentions")
     */
    public function index(RoomsRepository $repo_room, ChildGameRepository $repo_child, MobileRepository $mobiles_repo): Response
    {
        $rooms = $repo_room->findAll();
        $childs = $repo_child->findAll();
        $mobiles = $mobiles_repo->findAll();
        return $this->render('pages/mentions.html.twig', [
            'rooms' => $rooms,
            'childs' => $childs,
            'mobiles' => $mobiles
        ]);
    }
}
