<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Entity\Photos;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use App\Repository\PhotosRepository;
use App\Service\Uploader;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAlbumController extends AbstractController
{
    /**
     * @Route("/admin/album", name="admin_album")
     */
    public function index(AlbumRepository $repo_album): Response
    {
        $album = $repo_album->findBy([], ["createdAt" => "DESC"]);

        return $this->render('Admin/album/index.html.twig', [
            'album' => $album
        ]);
    }

    /**
     * ajout et modif des album
     * 
     * @Route("admin/album/create", name="createAlbum")
     * @Route("admin/album/{id}", name="modifAlbum", methods ="POST|GET")
     *
     * @param Album $album
     * @param Request $req
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function ajoutEtModif(Album $album = null, Request $req, EntityManagerInterface $manager)
    {

        if (!$album) {
            $album = new Album();
        }

        $form = $this->createForm(AlbumType::class, $album);
        $now = new DateTime('now');
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $modif = $album->getId() !== null;
            if($album->getCreatedAt() == null){
                $album->setCreatedAt($now);
            }
            // ADD IMAGES IN CASCADE 
            $images = $form->get('images')->getData();
            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('album_directory'),
                    $fichier
                );
                $img = new Photos();
                $img->setName($fichier);
                $album->addPhoto($img);
            }
            $manager->persist($album);
            $manager->flush();
            $this->addFlash("success", ($modif) ? "la modification a bien été éffectuée" : "l'ajout a bien été effectué ");
            return $this->redirectToRoute("admin_album");
        }

        return $this->render('admin/album/AMAlbum.html.twig', [
            "album" => $album,
            "form" => $form->createView(),
            'edit' => $album->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/mage/{id}", name="article_delete_image")
     */
    public function deleteImage(Photos $image, Request $req){
        if($this->isCsrfTokenValid("SUP" .$image->getId(), $req->get('_token'))){
            $name = $image->getName();
            unlink($this->getParameter('album_directory').'/'.$name);
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();
            return $this->redirectToRoute('admin_album');
        }
        $this->addFlash('success','Modification éffectué');
        return $this->redirectToRoute('admin_actu');
    }

    /**
     * delete images
     * 
     * @Route("/delete/image/{id}", name="album_delete")
     */
    public function deleteAlbum(Album $album, Request $req, PhotosRepository $image_repo, EntityManagerInterface $manager){
        if($this->isCsrfTokenValid("SUP".$album->getId(), $req->get("_token"))){
            $images = $image_repo->findAll(["album" => $album]);
            foreach($images as $image){
                $name2 = $image->getName();
                unlink($this->getParameter("album_directory"."/".$name2));
                $manager->remove($image);
                $manager->flush();
            }
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();
            return $this->redirectToRoute('admin_album');
        }
    }

  
}
