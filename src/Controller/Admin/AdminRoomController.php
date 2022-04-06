<?php

namespace App\Controller\Admin;

use App\Entity\Rooms;
use App\Form\RoomType;
use App\Repository\RoomsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminRoomController extends AbstractController
{
    /**
     * @Route("/admin/room", name="admin_room")
     */
    public function index(RoomsRepository $repo_room): Response
    {
        $rooms = $repo_room->findAll();
        return $this->render('Admin/room/index.html.twig', [
            "rooms" => $rooms
        ]);
    }

    /**
     * @Route("/admin/room/new", name="newRoom")
     * @Route("/admin/room/{id}", name="editRoom")
     */

     public function editAddRoom(Rooms $room = null, EntityManagerInterface $manager, Request $req){

        if(!$room){
            $room = new Rooms();
        }
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            $modif = $room->getId() !== null;
            $images = $form->get('image')->getData();
            $backs = $form->get('background')->getData();
            
            if($form->get('image')->getData() != null){
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $room->setImage($fichier);
            }

            if($form->get('background')->getData() != null){
                $fichier = md5(uniqid()) . '.' . $backs->guessExtension();
                $backs->move(
                    $this->getparameter('images_directory'),
                    $fichier
                );
                $room->setBackground($fichier); 
            }

            $manager->persist($room);
            $manager-> flush();

            $this->addFlash("success", ($modif) ? "la modification a bien été éffectuée" : "l'ajout a bien été effectué ");
            return $this->redirectToRoute("admin_room");
        }
        return $this->render('Admin/room/editAddRoom.html.twig', [
            "room" => $room,
            "form" => $form->createView(),
        ]);
     }

    /**
     * @Route("/admin/room/del/{id}", name="delRoom")
     */
    public function delComment(Rooms $room, EntityManagerInterface $manager, Request $req){

        if ($this->isCsrfTokenValid("SUP".$room->getId(),$req->get('_token'))) {
            if($room->getImage() != null){
                unlink($this->getParameter('images_directory').'/'.$room->getImage());
            }
            if($room->getBackground() != null){
                unlink($this->getParameter('images_directory').'/'.$room->getBackground());
            }
            $manager->remove($room);
            $manager->flush();
            $this->addFlash("success", "suppréssion éffectuer");
            return $this->redirectToRoute('admin_room');
        }
        $this->addFlash('success','Modification éffectué');
        return $this->redirectToRoute('admin_room');
    }
}
