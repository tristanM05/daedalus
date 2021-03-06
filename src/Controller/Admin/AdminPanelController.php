<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPanelController extends AbstractController
{
    /**
     * @Route("/admin/panel", name="admin_panel")
     */
    public function index(): Response
    {
        return $this->render('Admin/adminPanel.html.twig', [
            'controller_name' => 'AdminPanelController',
        ]);
    }
}
