<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ChildGameRepository;
use App\Repository\MobileRepository;
use App\Repository\RoomsRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(RoomsRepository $repo_room, MailerInterface $mailer, Request $req, ChildGameRepository $repo_child, MobileRepository $mobiles_repo): Response
    {
        $rooms = $repo_room->findAll();
        $childs = $repo_child->findAll();
        $mobiles = $mobiles_repo->findAll();

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($req);

        $messageContact = $contact->getMessage();
        $mail = $contact->getEmail();
        $lastname = $contact->getLastname();
        $firstname = $contact->getFirstname();
        $society = $contact->getSociety();
        $phone = $contact->getPhone();
        $secu = $contact->getSecu();

        if($form->isSubmitted() && $form->isValid() && $secu == "4"){
            $message = (new TemplatedEmail())
                ->from($mail)
                ->to('daedalusescapegame@outlook.fr')
                ->html("<p>
                Email: $mail<br>
                Téléphone: $phone<br>
                Nom: $lastname $firstname<br>
                Message: $messageContact
                </p>");

                $mailer->send($message);
                $this->addFlash("success", "Votre message a bien été envoyé ! ");
                return $this->redirectToRoute("contact");
        }
        return $this->render('pages/contact.html.twig', [
            'rooms' => $rooms,
            'form' => $form->createView(),
            'childs' => $childs,
            'mobiles' => $mobiles
        ]);
    }
}
