<?php

namespace App\Controller\Admin;

use App\Entity\Infocitygame;
use App\Form\InfocityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCityInfoController extends AbstractController
{
    /**
     * @Route("/admin/city/info/new", name="newCityInfo")
     * @Route("/admin/city/info/{id}}", name="editCityInfo")
     */
    public function index(EntityManagerInterface $manager, Request $req, Infocitygame $info = null)
    {
        if(!$info){
            $info = new Infocitygame();
        }
        $form = $this->createForm(InfocityType::class, $info);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $modif = $info->getId() !== null;
            $manager->persist($info);
            $manager->flush();

            $this->addFlash("success", ($modif) ? "la modification a bien été éffectuée" : "l'ajout a bien été effectué ");
            return $this->redirectToRoute("admin_city");
        }
        return $this->render('Admin/cityGame/addEdittInfo.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
