<?php

namespace App\Controller;

use App\Repository\ChildGameRepository;
use App\Repository\MobileRepository;
use App\Repository\PartenaireRepository;
use App\Repository\RoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartenairesController extends AbstractController
{
    /**
     * @Route("/partenaires", name="partenaires")
     */
    public function index(RoomsRepository $repo_room, PartenaireRepository $repo_part, ChildGameRepository $repo_child, MobileRepository $mobiles_repo): Response
    {
        $rooms = $repo_room->findAll();
        $part = $repo_part->findBy([], ["ordre" => "ASC"]);
        $childs = $repo_child->findAll();
        $mobiles = $mobiles_repo->findAll();
        $count = count($part);
        if($count == 1){
            $count;
        }elseif($count > 1){
            $count;
        }

        return $this->render('pages/partenaire.html.twig', [
            'rooms' => $rooms,
            'partenaire' => $part,
            'count' => $count,
            'childs' => $childs,
            'mobiles' => $mobiles
        ]);
    }
}
