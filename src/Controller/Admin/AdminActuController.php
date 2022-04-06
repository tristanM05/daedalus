<?php

namespace App\Controller\Admin;

use App\Entity\Actu;
use App\Form\ActuType;
use App\Repository\ActuRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminActuController extends AbstractController
{
    /**
     * @Route("/admin/actu", name="admin_actu")
     */
    public function index(ActuRepository $repo_actu): Response
    {
        $actu = $repo_actu->findBy([], ["createdAt" => "DESC"]);

        return $this->render('Admin/actu/index.html.twig', [
            'actus' => $actu
        ]);
    }

    /**
     * @Route("/admin/act/new", name="newActu")
     * @Route("/admin/act/{id}", name="editActu")
     */
    public function editAddActu(EntityManagerInterface $manager, Request $req, Actu $actu = null){

        if(!$actu){
            $actu = new Actu();
        }
        $now = new DateTime('now');
        $form = $this->createForm(ActuType::class, $actu);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $modif = $actu->getId() !== null;
            $images = $form->get('image')->getData();
            if($form->get('image')->getData() != null){
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('actu_directory'),
                    $fichier
                );
                $actu->setImage($fichier);
            }
            
            $actu->setIsSelect(0);
            if($actu->getCreatedAt() == null){
                $actu->setCreatedAt($now);
            }
            $manager->persist($actu);
            $manager->flush();

            $this->addFlash("success", ($modif) ? "la modification a bien été éffectuée" : "l'ajout a bien été effectué ");
            return $this->redirectToRoute("admin_actu");
        }
        return $this->render('Admin/actu/editAddActu.html.twig', [
            "actu" => $actu,
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/actu/accept/{id}", name="acceptActu")
     */
    public function acceptComment(Actu $actu, EntityManagerInterface $manager, Request $reg){
        $actu->setIsSelect(1);
        $manager->persist($actu);
        $manager->flush(); 
        $this->addFlash('success','Actualité mise en avant sur la page d\'accueil.');
        return $this->redirectToRoute('admin_actu');
    }

    /**
     * @Route("/admin/actu/retire/{id}", name="retireActu")
     */
    public function RetireComment(Actu $actu, EntityManagerInterface $manager, Request $reg){
        $actu->setIsSelect(0);
        $manager->persist($actu);
        $manager->flush(); 
        $this->addFlash('success','Actualité retiré de la page d\'accueil');
        return $this->redirectToRoute('admin_actu');
    }

    /**
     * @Route("/admin/actu/del/{id}", name="delActu")
     */
    public function delComment(Actu $actu, EntityManagerInterface $manager, Request $req){

        if ($this->isCsrfTokenValid("SUP".$actu->getId(),$req->get('_token'))) {
            if($actu->getImage() != null){
                unlink($this->getParameter('actu_directory').'/'.$actu->getImage());
            }
            $manager->remove($actu);
            $manager->flush();
            $this->addFlash("success", "suppréssion éffectuer");
            return $this->redirectToRoute('admin_actu');
        }
        $this->addFlash('success','Modification éffectué');
        return $this->redirectToRoute('admin_actu');
    }
}
