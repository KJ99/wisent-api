<?php


namespace App\Controller;


use App\DataFactory\ReservationDataFactory;
use App\Entity\Contact;
use App\Service\ReservationService;
use App\ViewModel\RequestViewModel\ReservationRequestViewModel;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Rest\Route("/v1/reservations", name="reservations_")
 */
class ReservationsController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("", name="create")
     * @OA\Tag(name="Reservations")
     * @ParamConverter("params", class="App\ViewModel\RequestViewModel\ReservationRequestViewModel::class", converter="fos_rest.request_body")
     *
     */
    public function reserve(ReservationRequestViewModel $params, ?Contact $contact, ReservationDataFactory $factory) {
        $params->setContact($contact);
        $response = $factory->create($params);
        return $this->json($response->getViewModel(), $response->getHttpCode());
    }

    /**
     * @Rest\Get("/places/{day}", name="available_places")
     * @OA\Tag(name="Reservations")
     * @OA\Parameter(name="day", in="path", schema=@OA\Schema(type="string"), example="2021-01-30", description="Requested date in format YYYY-MM-DD")
     * @OA\Response(
     *     response=200,
     *     description="Count of available places for the date",
     *     @Model(type=App\ViewModel\ResponseViewModel\AvailablePlacesResponseViewModel::class)
     * )
     * @param string $day
     * @return JsonResponse
     */
    public function getAvailablePlaces(string $day, ReservationService $reservationService) {
        $response = $reservationService->getAvailablePlaces($day);
        return $this->json($response->getViewModel(), $response->getHttpCode());
    }
}