<?php

namespace App\Controller\Admin;

use App\Repository\CitygameRepository;
use App\Repository\InfocitygameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;use App\Entity\Citygame;
use App\Form\CityGameType;

class AdminCityController extends AbstractController
{
    /**
     * @Route("/admin/city", name="admin_city")
     */
    public function index(CitygameRepository $repo_city, InfocitygameRepository $repo_info): Response
    {
        $city = $repo_city->findAll();
        $info = $repo_info->findAll();
        return $this->render('Admin/cityGame/index.html.twig', [
            'city' => $city,
            'info' => $info,
        ]);
    }

    /**
     * @Route("/admin/escape_ville/new", name="newCity")
     * @Route("/admin/escape_ville/{id}", name="editCity")
     */

    public function editAddRoom(Citygame $city = null, EntityManagerInterface $manager, Request $req){

        if(!$city){
            $city = new Citygame();
        }
        $form = $this->createForm(CityGameType::class, $city);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            $modif = $city->getId() !== null;
            $images = $form->get('image')->getData();
            $backs = $form->get('background')->getData();
            
            if($form->get('image')->getData() != null){
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $city->setImage($fichier);
            }

            if($form->get('background')->getData() != null){
                $fichier = md5(uniqid()) . '.' . $backs->guessExtension();
                $backs->move(
                    $this->getparameter('images_directory'),
                    $fichier
                );
                $city->setBackground($fichier); 
            }

            $manager->persist($city);
            $manager-> flush();

            $this->addFlash("success", ($modif) ? "la modification a bien été éffectuée" : "l'ajout a bien été effectué ");
            return $this->redirectToRoute("admin_city");
        }
        return $this->render('Admin/cityGame/editAddGame.html.twig', [
            "city" => $city,
            "form" => $form->createView(),
        ]);
     }
     
    /**
     * @Route("/admin/city/del/{id}", name="delCity")
     */
    public function delComment(Citygame $city, EntityManagerInterface $manager, Request $req){

        if ($this->isCsrfTokenValid("SUP".$city->getId(),$req->get('_token'))) {

            if($city->getImage() != null){
                unlink($this->getParameter('images_directory').'/'.$city->getImage());
            }
            if($city->getBackground() != null){
                unlink($this->getParameter('images_directory').'/'.$city->getBackground());
            }
            $manager->remove($city);
            $manager->flush();
            $this->addFlash("success", "suppréssion éffectuer");
            return $this->redirectToRoute('admin_comment');
        }
        $this->addFlash('success','Modification éffectué');
        return $this->redirectToRoute('admin_comment');
    }
}
