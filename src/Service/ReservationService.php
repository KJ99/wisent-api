<?php


namespace App\Service;


use App\Entity\Reservation;
use App\Result\Result;
use App\ViewModel\ResponseViewModel\AvailablePlacesResponseViewModel;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ReservationService
{
    private EntityManagerInterface $em;
    private LoggerInterface $logger;
    private ParameterBagInterface $params;

    public function __construct(EntityManagerInterface $em, LoggerInterface $logger, ParameterBagInterface $params) {
        $this->em = $em;
        $this->logger = $logger;
        $this->params = $params;
    }

    public function getAvailablePlaces(string $day): Result {
        $result = new Result();
        $placesCount = $this->getAvailablePlacesCount($day);
        $viewModel = new AvailablePlacesResponseViewModel();
        $viewModel->setDate($day);
        $viewModel->setAvailablePlaces($placesCount);
        $result->setViewModel($viewModel);
        return $result;
    }

    private function getAvailablePlacesCount(string $date): int {
        $maxSeats = $this->params->get('max_seats_to_reserve');
        $reservedSeats = 0;
        try {
            $reservedSeats = $this->em->getRepository(Reservation::class)->countOfReservedSeatsForDate($date);
        } catch (\Throwable $e) {
            $this->logger->warning(self::class . ' caught exception ' . $e->getMessage() . ' details: ' . json_encode($e));
            $reservedSeats = $maxSeats;
        }
        return $maxSeats - intval($reservedSeats);
    }

}