<?php


namespace App\Controller;


use App\Entity\Dish;
use App\Entity\User;
use App\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ResourcesController
 * @package App\Controller
 * @Route("/resources", name="resources_")
 */
class ResourcesController extends AbstractController
{
    /**
     * @Route("/pictures/dishes/{id}", name="pictures_dish", methods={"GET"})
     */
    public function dishPicture(Request $request, Dish $dish) {
        $picture = $dish->getPicture();
        $response = new BinaryFileResponse(FileService::getFilePath($picture));
        $response->headers->set('Content-Type', $picture->getMime());
        return $response;
    }

    /**
     * @Route("/users/avatars/{id}", name="users_avatar", methods={"GET"})
     */
    public function userAvatar(Request $request, User $user) {
        $picture = $user->getPicture();
        $response = new BinaryFileResponse(FileService::getFilePath($picture));
        $response->headers->set('Content-Type', $picture->getMime());
        return $response;
    }
}