<?php

namespace App\Controller\Admin;

use App\Entity\Partenaire;
use App\Form\PartenaireType;
use App\Repository\PartenaireRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPartenaireController extends AbstractController
{
    /**
     * @Route("/admin/partenaire", name="admin_partenaire")
     */
    public function index(PartenaireRepository $repo): Response
    {
        $partanaire = $repo->findBy([], ["ordre" => "ASC"]);

        return $this->render('Admin/partenaire/index.html.twig', [
            'partenaire' => $partanaire,
        ]);
    }

    /**
     * @Route("/admin/part/new", name="newPartenaire")
     * @Route("/admin/part/{id}", name="editPartenaire")
     */
    public function editAddPartenaire(EntityManagerInterface $manager, Request $req, Partenaire $partenaire = null){
            
            if(!$partenaire){
                $partenaire = new Partenaire();
            }
            $form = $this->createForm(PartenaireType::class, $partenaire);
            $form->handleRequest($req);
            if($form->isSubmitted() && $form->isValid()){
                $modif = $partenaire->getId() !== null;
                $images = $form->get('image')->getData();
                if($form->get('image')->getData() != null){
                    $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                    $images->move(
                        $this->getParameter('partenaire_directory'),
                        $fichier
                    );
                    $partenaire->setImage($fichier);
                }
                $logo = $form->get('logo')->getData();
                if($form->get('logo')->getData() != null){
                    $fichier = md5(uniqid()) . '.' . $logo->guessExtension();
                    $logo->move(
                        $this->getParameter('partenaire_directory'),
                        $fichier
                    );
                    $partenaire->setLogo($fichier);
                }
           
                $manager->persist($partenaire);
                $manager->flush();          
                $this->addFlash("success", ($modif) ? "la modification a bien été éffectuée" : "l'ajout a bien été effectué ");
                return $this->redirectToRoute("admin_partenaire");
            }
            return $this->render('Admin/partenaire/editAddPart.html.twig', [
                "partenaire" => $partenaire,
                "form" => $form->createView(),
            ]);
    }

    /**
     * @Route("/admin/part/delete/{id}", name="deletePartenaire")
     */
    public function deletePartenaire(EntityManagerInterface $manager, Partenaire $partenaire, Request $req){
        if ($this->isCsrfTokenValid("SUP".$partenaire->getId(),$req->get('_token'))) {
            if($partenaire->getImage() != null){
                unlink($this->getParameter('partenaire_directory').'/'.$partenaire->getImage());
                unlink($this->getParameter('partenaire_directory').'/'.$partenaire->getLogo());
            }
            $manager->remove($partenaire);
            $manager->flush();
        }
        $this->addFlash("success", "la suppression a bien été effectuée");
        return $this->redirectToRoute("admin_partenaire");
    }    
}
