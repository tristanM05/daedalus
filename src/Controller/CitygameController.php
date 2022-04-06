<?php

namespace App\Controller;

use App\Entity\Citygame;
use App\Form\CityGameType;
use App\Repository\CitygameRepository;
use App\Repository\InfocitygameRepository;
use App\Repository\RoomsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CitygameController extends AbstractController
{
    /**
     * @Route("/citygame", name="citygame")
     */
    public function index(InfocitygameRepository $repo_info, RoomsRepository $repo_room, CitygameRepository $repo_city): Response
    {
        $info = $repo_info->findAll();
        $rooms = $repo_room->findAll();
        $city = $repo_city->findAll();
        return $this->render('pages/citygame.html.twig', [
            'info' => $info,
            'rooms' => $rooms,
            'city' => $city
            
        ]);
    }

    
}
