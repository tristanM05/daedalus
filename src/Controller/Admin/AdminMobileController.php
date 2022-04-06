<?php

namespace App\Controller\Admin;

use App\Entity\Mobile;
use App\Form\MobileType;
use App\Repository\MobileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMobileController extends AbstractController
{
    /**
     * @Route("/admin/mobile", name="admin_mobile")
     */
    public function index(MobileRepository $repo_mobile): Response
    {
        $mobile = $repo_mobile->findAll();
        return $this->render('Admin/mobile/index.html.twig', [
            'mobile' => $mobile
        ]);
    }
        /**
     * @Route("/admin/escape_mobile/new", name="newMobile")
     * @Route("/admin/escape_mobile/{id}", name="editMobile")
     */

    public function editAddRoom(Mobile $mobile = null, EntityManagerInterface $manager, Request $req){

        if(!$mobile){
            $mobile = new Mobile();
        }
        $form = $this->createForm(MobileType::class, $mobile);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            $modif = $mobile->getId() !== null;
            $images = $form->get('image')->getData();
            $backs = $form->get('background')->getData();
            
            if($form->get('image')->getData() != null){
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $mobile->setImage($fichier);
            }

            if($form->get('background')->getData() != null){
                $fichier = md5(uniqid()) . '.' . $backs->guessExtension();
                $backs->move(
                    $this->getparameter('images_directory'),
                    $fichier
                );
                $mobile->setBackground($fichier); 
            }

            $manager->persist($mobile);
            $manager-> flush();

            $this->addFlash("success", ($modif) ? "la modification a bien été éffectuée" : "l'ajout a bien été effectué ");
            return $this->redirectToRoute("admin_mobile");
        }
        return $this->render('Admin/mobile/editAddMobile.html.twig', [
            "mobile" => $mobile,
            "form" => $form->createView(),
        ]);
     }

      /**
     * @Route("/admin/mobile/del/{id}", name="delMobile")
     */
    public function delComment(Mobile $mobile, EntityManagerInterface $manager, Request $req){

        if ($this->isCsrfTokenValid("SUP".$mobile->getId(),$req->get('_token'))) {

            if($mobile->getImage() != null){
                unlink($this->getParameter('images_directory').'/'.$mobile->getImage());
            }
            if($mobile->getBackground() != null){
                unlink($this->getParameter('images_directory').'/'.$mobile->getBackground());
            }
            $manager->remove($mobile);
            $manager->flush();
            $this->addFlash("success", "suppréssion éffectuer");
            return $this->redirectToRoute('admin_mobile');
        }
        $this->addFlash('success','Modification éffectué');
        return $this->redirectToRoute('admin_mobilet');
    }
}
