<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ActuRepository;
use App\Repository\ChildGameRepository;
use App\Repository\CommentRepository;
use App\Repository\MobileRepository;
use App\Repository\RoomsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use DateTime;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment", name="comment")
     */
    public function index(CommentRepository $repo_comment, EntityManagerInterface $manager, Request $req, MailerInterface $mailer, RoomsRepository $repo_room, ChildGameRepository $repo_child, MobileRepository $mobiles_repo): Response
    {
        $rooms = $repo_room->findAll();
        $allComments = $repo_comment->findBy(["isOk" => 1], ["createdAt" => "DESC"]);
        $now = new DateTime('now');
        $childs = $repo_child->findAll();
        $mobiles = $mobiles_repo->findAll();

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($req);
        $mail = $comment->getMail();
        $message = $comment->getMessage();
        if($form->isSubmitted() && $form->isValid()){
            $message = (new TemplatedEmail())
                ->from($mail)
                ->to("daedalus@contact.fr")
                ->subject("Nouveaux commentaire")
                ->html("<p>
                Email: $mail()<br>
                Message: $message
                </p>");
            $mailer->send($message);
            $comment->setIsOk(0);
            $comment->setCreatedAt($now);
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash("success", "Votre message a bien été envoyez !  ");
            return $this->redirectToRoute("comment");
        }

        return $this->render('pages/comment.html.twig', [
            'form' => $form->createView(),
            "comments" => $allComments,
            'rooms' => $rooms,
            'childs' => $childs,
            'mobiles' => $mobiles,
        ]);
    }


}
