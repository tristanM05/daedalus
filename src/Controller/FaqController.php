<?php

namespace App\Controller;

use App\Repository\FaqRepository;
use App\Repository\RoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FaqController extends AbstractController
{
    /**
     * @Route("/faq", name="faq")
     */
    public function index(FaqRepository $repo_faq, RoomsRepository $repo_room): Response
    {
        $faq = $repo_faq->findAll();
        $rooms = $repo_room->findAll();
        return $this->render('pages/faq.html.twig', [
            'faq' => $faq,
            'rooms' => $rooms
        ]);
    }
}
