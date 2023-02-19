<?php

namespace App\Controller\Admin;

use App\Entity\ChildGame;
use App\Form\ChildType;
use App\Repository\ChildGameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminChildController extends AbstractController
{
    /**
     * @Route("/admin/child", name="admin_child")
     */
    public function index(ChildGameRepository $repo_child): Response
    {
        $childs = $repo_child->findAll();
        return $this->render('Admin/admin_child/child.html.twig', [
            'childs' => $childs
        ]);
    }

    /**
     * @Route("/admin/child/new", name="newChild")
     * @Route("/admin/child/{id}", name="editChild")
     */
    public function editAddRoom(ChildGame $child = null, EntityManagerInterface $manager, Request $req){

        if(!$child){
            $child = new ChildGame();
        }
        $form = $this->createForm(ChildType::class, $child);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            $modif = $child->getId() !== null;
            $images = $form->get('image')->getData();
            $backs = $form->get('background')->getData();
            
            if($form->get('image')->getData() != null){
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $child->setImage($fichier);
            }

            if($form->get('background')->getData() != null){
                $fichier = md5(uniqid()) . '.' . $backs->guessExtension();
                $backs->move(
                    $this->getparameter('images_directory'),
                    $fichier
                );
                $child->setBackground($fichier); 
            }

            $manager->persist($child);
            $manager-> flush();

            $this->addFlash("success", ($modif) ? "la modification a bien été éffectuée" : "l'ajout a bien été effectué ");
            return $this->redirectToRoute("admin_room");
        }
        return $this->render('Admin/admin_child/addEditChild.html.twig', [
            "child" => $child,
            "form" => $form->createView(),
        ]);
     }
}
