<?php

namespace App\Controller;

use App\Repository\MobileRepository;
use App\Repository\RoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MobileController extends AbstractController
{
    /**
     * @Route("/mobile", name="mobile")
     */
    public function index(MobileRepository $repo_mobile, RoomsRepository $repo_room): Response
    {
        $mobile = $repo_mobile->findBy([], ["id" => "DESC"]);
        $rooms = $repo_room->findAll();

        return $this->render('pages/mobile.html.twig', [
            'mobile' => $mobile,
            'rooms' => $rooms,
        ]);
    }
}
