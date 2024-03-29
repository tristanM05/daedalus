<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ActuRepository;
use App\Repository\ChildGameRepository;
use App\Repository\InfoRepository;
use App\Repository\MobileRepository;
use App\Repository\RoomsRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $req, MailerInterface $mailer, InfoRepository $repo_info, RoomsRepository $repo_room, ActuRepository $repo_actu, ChildGameRepository $repo_child, MobileRepository $mobiles_repo): Response
    {
        $actu = $repo_actu->findBy(["isSelect" => 1], ["createdAt" => "DESC"]);
        $rooms = $repo_room->findAll();
        $info = $repo_info->findAll();
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
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'info' => $info,
            'rooms' => $rooms,
            "actus" => $actu,
            'childs' => $childs,
            'mobiles' => $mobiles
        ]);
    }
}
