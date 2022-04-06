<?php

namespace App\Controller;

use App\Entity\Album;
use App\Repository\AlbumRepository;
use App\Repository\RoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlbumController extends AbstractController
{
    /**
     * @Route("/album-photo", name="allAlbum")
     */
    public function index(AlbumRepository $repo_album, RoomsRepository $repo_room): Response
    {

        $album = $repo_album->findBy([], ['createdAt' => 'DESC']);
        $rooms = $repo_room->findAll();
        return $this->render('pages/allAlbum.html.twig', [
            'album' => $album,
            'rooms' => $rooms
        ]);
    }

    /**
     * @Route("/album-photo/{id}", name="album")
     */

     public function album(Album $album, RoomsRepository $repo_room){
        $rooms = $repo_room->findAll();

        return $this->render('pages/album.html.twig', [
            'album' => $album,
            'rooms' => $rooms
        ]);
     }
}
