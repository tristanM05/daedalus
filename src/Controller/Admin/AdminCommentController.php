<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="admin_comment")
     */
    public function index(CommentRepository $repo_comment): Response
    {

        $comment = $repo_comment->findBy([], ['createdAt' => "DESC"]);

        return $this->render('Admin/comment/comment.html.twig', [
            "comment" => $comment
        ]);
    }

    /**
     * @Route("/admin/comment/{id}", name="viewComment")
     */
    public function viewMessage(Comment $comment){

        return $this->render('Admin/comment/viewComment.html.twig', [
            "comment" => $comment
        ]);
    }

    /**
     * @Route("/admin/comment/accept/{id}", name="acceptComment")
     */
    public function acceptComment(Comment $comment, EntityManagerInterface $manager, Request $reg){
        $comment->setIsOk(1);
        $manager->persist($comment);
        $manager->flush(); 
        $this->addFlash('success','Commentaire validé ! Il sera visible par tous les utilisateurs.');
        return $this->redirectToRoute('admin_comment');
    }

    /**
     * @Route("/admin/comment/retire/{id}", name="retireComment")
     */
    public function RetireComment(Comment $comment, EntityManagerInterface $manager, Request $reg){
        $comment->setIsOk(0);
        $manager->persist($comment);
        $manager->flush(); 
        $this->addFlash('success','Commentaire retiré ! Il ne sera plus visible par les utilisateurs');
        return $this->redirectToRoute('admin_comment');
    }

    /**
     * @Route("/admin/comment/del/{id}", name="delComment")
     */
    public function delComment(Comment $comment, EntityManagerInterface $manager, Request $req){

        if ($this->isCsrfTokenValid("SUP".$comment->getId(),$req->get('_token'))) {

            $manager->remove($comment);
            $manager->flush();
            $this->addFlash("success", "suppréssion éffectuer");
            return $this->redirectToRoute('admin_comment');
        }
        $this->addFlash('success','Modification éffectué');
        return $this->redirectToRoute('admin_comment');
    }
}
