<?php

namespace App\Controller\Admin;

use App\Entity\PasswordUpdate;
use App\Form\AdminInfoType;
use App\Form\PasswordUpdateType;
use App\Repository\ChildGameRepository;
use App\Repository\RoomsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityAdminController extends AbstractController
{
    /**
     * @Route("/admin/log", name="admin_log")
     */
    public function login(AuthenticationUtils $outils,RoomsRepository $repo_room, ChildGameRepository $repo_child): Response
    {
        $rooms = $repo_room->findAll();
        $erreur = $outils->getLastAuthenticationError();
        $identifiant = $outils->getLastUsername();
        $childs = $repo_child->findAll();

        return $this->render('Admin/securityAdmin.html.twig', [
            'erreur' => $erreur !== null,
            'identifiant' => $identifiant,
            'rooms' => $rooms,
            'childs' => $childs
        ]);
    }

    /**
     * @Route("/admin/modif", name="admin_modif")
     */
    public function modifInfoAdmin(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){

        $user = $this->getUser();

        $form_info = $this->createForm(AdminInfoType::class, $user);
        $form_info->handleRequest($request);
        if($form_info->isSubmitted() && $form_info->isValid()){
            $manager->persist($user);
            $manager->flush();
        }

        $passwordUpdate = new PasswordUpdate();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //verifié le oldpassword
            if(!password_verify($passwordUpdate->getOldPassword(), $user->getPass())){
                //gérer l'erreur
                $form->get('oldPassword')->addError(new FormError("Le mot de passe ne correspond pas a votre mot de passe actuel"));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);

                $user->setPass($hash);

                $manager->persist($user);
                $manager->flush($user);

                $this->addFlash(
                    'success',
                    "Votre mot de passe a bien été modifié !"
                );
            }
        }

        return $this->render('Admin/adminInfo.html.twig', [
            'form_info' => $form_info->createView(),
            'form' => $form->createView(),
        ]);

    }

    /**
     * Allows an administrator to log out
     * 
    * @Route("/admin/logout", name="admin_logout")
    */
    public function logout(){
        
    }
}
