<?php

namespace App\Controller;

use App\Entity\Mobile;
use App\Repository\ChildGameRepository;
use App\Repository\MobileRepository;
use App\Repository\RoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MobileController extends AbstractController
{
    /**
     * @Route("/mobile/{id}", name="mobile")
     */
    public function index(MobileRepository $repo_mobile, RoomsRepository $repo_room, ChildGameRepository $rpeo_child, Mobile $thisMobile, MobileRepository $mobiles_repo): Response
    {
        $mobile = $repo_mobile->findBy([], ["id" => "DESC"]);
        $rooms = $repo_room->findAll();
        $childs = $rpeo_child->findAll();
        $mobiles = $mobiles_repo->findAll();
        return $this->render('pages/mobile.html.twig', [
            'mobile' => $mobile,
            'rooms' => $rooms,
            'childs' => $childs,
            'thisMobile' => $thisMobile,
            'mobiles' => $mobiles
        ]);
    }
}
