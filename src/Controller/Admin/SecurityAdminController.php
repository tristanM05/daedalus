<?php

namespace App\Controller\Admin;

use App\Repository\RoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityAdminController extends AbstractController
{
    /**
     * @Route("/admin/log", name="admin_log")
     */
    public function login(AuthenticationUtils $outils,RoomsRepository $repo_room): Response
    {
        $rooms = $repo_room->findAll();
        $erreur = $outils->getLastAuthenticationError();
        $identifiant = $outils->getLastUsername();

        return $this->render('Admin/securityAdmin.html.twig', [
            'erreur' => $erreur !== null,
            'identifiant' => $identifiant,
            'rooms' => $rooms,
        ]);
    }

    /**
     * Allows an administrator to log out
     * 
    * @Route("/admin/logout", name="admin_logout")
    */
    public function logout(){
        
    }
}
