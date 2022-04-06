<?php

namespace App\Controller\Admin;

use App\Entity\Faq;
use App\Form\FaqType;
use App\Repository\FaqRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminFaqController extends AbstractController
{
    /**
     * @Route("/admin/faq", name="admin_faq")
     */
    public function index(FaqRepository $repo_faq): Response
    {
        $faq = $repo_faq->findAll();
        return $this->render('Admin/faq/faq.html.twig', [
            'faq' => $faq,
        ]);
    }

    /**
     * @Route("admin/faq/create", name="createFaq")
     * @Route("admin/faq/{id}", name="modifFaq")
     *
     */
    public function editAddFaq(Faq $faq = null, Request $req, EntityManagerInterface $manager){
        
        if(!$faq){
            $faq = new Faq();
        }

        $form = $this->createForm(FaqType::class, $faq);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $modif = $faq->getId() !== null;
            $manager->persist($faq);
            $manager->flush();

            $this->addFlash("success", ($modif) ? "la modification a bien été éffectuée" : "l'ajout a bien été effectué ");
            return $this->redirectToRoute("admin_faq");
        }

        return $this->render('Admin/faq/editAddFaq.html.twig', [
            "faq" => $faq,
            "form" => $form->createView(),
        ]);
    }

    /**
     * delete fAQ
     *@Route("admin/delete/faq/{id}", name="supFaq")
     * @return void
     */
    public function supFaq(Faq $faq, EntityManagerInterface $manager, Request $req){

        if($this->isCsrfTokenValid('SUP' . $faq->getId(), $req->get('_token'))){
            $manager->remove($faq);
            $manager->flush();
            $this->addFlash("success", "La supression a bien été éffectuée");
            return $this->redirectToRoute("admin_faq");
        }
        
    }


}
