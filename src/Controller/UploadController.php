<?php


namespace App\Controller;


use App\Entity\Picture;
use App\Service\FileService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/v1/upload", name="upload_")
 */
class UploadController extends AbstractFOSRestController
{


    /**
     * @param Request $request
     * @Rest\Post("/image", name="image")
     * @OA\Tag(name="Upload")
     * @OA\RequestBody(
     *     required=true,
     *     description="Request body",
     *     @OA\MediaType(
     *      mediaType="multipart/form-data",
     *     @OA\Schema(@OA\Property(property="file", type="file"))
     * )
     * )
     * @OA\Response(
     *     response=201,
     *     description="File uploaded successfully",
     *     @Model(type=App\ViewModel\ResponseViewModel\UploadResponseViewModel::class)
     * )
     * @return JsonResponse
     */
    public function uploadImage(Request $request, FileService $fileService, LoggerInterface $logger) {
        $logger->info(json_encode($request->files));
        $response = $fileService->resolveFile($request->files->get('file'));
        return $this->json($response->getViewModel(), $response->getHttpCode());
    }

    /**
     * @param Request $request
     * @param Picture $picture
     * @return JsonResponse
     * @Rest\Delete("/image/{id}", name="image_delete")
     * @OA\Tag(name="Upload")
     * @OA\Parameter(name="id", in="path", description="Image id", schema=@OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="file deleted",
     *     @OA\JsonContent(type="object", @OA\Property(property="message", type="string", example="File deleted"), @OA\Property(property="id", type="integer"))
     * )
     */
    public function delete(?Picture $picture, FileService $fileService) {
        $response = $fileService->deleteFile($picture);
        return $this->json($response->getViewModel(), $response->getHttpCode());
    }
}