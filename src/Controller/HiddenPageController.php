<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HiddenPageController extends AbstractController
{
    /**
     * @Route("/hidden", name="hidden")
     */
    public function index(): Response
    {
        return $this->render('hidden_page/index.html.twig', [
            'controller_name' => 'HiddenPageController',
        ]);
    }

    /**
     * @Route("/hidden/audio1", name="audio1")
     */
    public function audio1()
    {
        return $this->render('hidden_page/audio1.html.twig', [
            'controller_name' => 'HiddenPageController',
        ]);
    }
    
    /**
     * @Route("/hidden/audio2", name="audio2")
     */
    public function audio2()
    {
        return $this->render('hidden_page/audio2.html.twig', [
            'controller_name' => 'HiddenPageController',
        ]);
    }
}
