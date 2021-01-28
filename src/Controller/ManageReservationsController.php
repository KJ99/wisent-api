<?php


namespace App\Controller;

use App\DataWarehouse\ReservationDataWarehouse;
use App\DataWarehouse\SubcategoryDataWarehouse;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Nelmio\ApiDocBundle\Annotation\Model;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;

/**
 * Class ManageReservationsController
 * @package App\Controller
 * @Rest\Route("/v1/manage/reservations", name="manage_reservations_")
 * @OA\Tag(name="Manage reservations")
 */
class ManageReservationsController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("", name="future")
     * @OA\Response(
     *     response=200,
     *     description="Returns list of future reservation",
     *     @OA\JsonContent(type="array", @OA\Items(ref=@Model(type=App\ViewModel\ResponseViewModel\ReservationResponseViewModel::class)))
     * )
     */
    public function getFuture(ReservationDataWarehouse $warehouse) {
        return $this->json($warehouse->get(), 200);
    }

    /**
     * @Rest\Get("/{id}", name="particular")
     * @OA\Parameter(name="id", in="path", description="Find particular reservation details", schema=@OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Returns single reservation info",
     *     @Model(type=App\ViewModel\ResponseViewModel\ReservationResponseViewModel::class)
     * )
     */
    public function getParticular(ReservationDataWarehouse $warehouse) {
        return $this->json($warehouse->get(), 200);
    }
}