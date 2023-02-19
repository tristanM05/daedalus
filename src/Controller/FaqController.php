<?php

namespace App\Controller;

use App\Repository\ChildGameRepository;
use App\Repository\FaqRepository;
use App\Repository\MobileRepository;
use App\Repository\RoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FaqController extends AbstractController
{
    /**
     * @Route("/faq", name="faq")
     */
    public function index(FaqRepository $repo_faq, RoomsRepository $repo_room, ChildGameRepository $repo_child, MobileRepository $mobiles_repo): Response
    {
        $faq = $repo_faq->findAll();
        $childs = $repo_child->findAll();
        $rooms = $repo_room->findAll();
        $mobiles = $mobiles_repo->findAll();
        return $this->render('pages/faq.html.twig', [
            'faq' => $faq,
            'rooms' => $rooms,
            'childs' => $childs,
            'mobiles' => $mobiles
        ]);
    }
}
