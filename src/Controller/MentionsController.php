<?php

namespace App\Controller;

use App\Repository\RoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MentionsController extends AbstractController
{
    /**
     * @Route("/mentions", name="mentions")
     */
    public function index(RoomsRepository $repo_room): Response
    {
        $rooms = $repo_room->findAll();
        return $this->render('pages/mentions.html.twig', [
            'rooms' => $rooms
        ]);
    }
}
