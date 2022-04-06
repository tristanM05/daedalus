<?php

namespace App\Controller\Admin;

use App\Entity\Info;
use App\Form\InfoType;
use App\Repository\InfoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminInfoController extends AbstractController
{
    /**
     * @Route("/admin/info", name="admin_info")
     */
    public function index(InfoRepository $repo_info): Response
    {
        $info = $repo_info->findAll();
        return $this->render('Admin/info/index.html.twig', [
            "info" => $info
        ]);
    }
    /**
     * @Route("/admin/info/new", name="newInfo")
     * @Route("admin/info/{id}", name="modifInfo")
     */

     public function newInfo(EntityManagerInterface $manager, Request $req, Info $info = null){

        if(!$info){
            $info = new Info();
        }
        $form = $this->createForm(InfoType::class, $info);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $modif = $info->getId() !== null;
            $manager->persist($info);
            $manager->flush();

            $this->addFlash("success", ($modif) ? "la modification a bien été éffectuée" : "l'ajout a bien été effectué ");
            return $this->redirectToRoute("admin_info");
        }

        return $this->render('Admin/info/editAddInfo.html.twig', [
            "form" => $form->createView(),
        ]);
     }

     /**
      * @Route("admin/delete/info/{id}", name="deleteInfo")
      */
      public function deleteInfo(Info $info, EntityManagerInterface $manager, Request $req){
        if($this->isCsrfTokenValid('SUP' . $info->getId(), $req->get('_token'))){
            $manager->remove($info);
            $manager->flush();
            $this->addFlash("success", "La supression a bien été éffectuée");
            return $this->redirectToRoute("admin_info");
        }
      }
}
