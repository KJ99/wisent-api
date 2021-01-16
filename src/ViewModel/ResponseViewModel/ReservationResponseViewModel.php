<?php


namespace App\ViewModel\ResponseViewModel;
use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;
use App\Entity\Reservation;


class ReservationResponseViewModel
{
    /**
     * @var string
     * @JMS\Type("string")
     */
    private string $number;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private string $date;

    /**
     * @var integer
     * @JMS\Type("integer")
     */
    private int $numberOfSeats;

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getNumberOfSeats(): int
    {
        return $this->numberOfSeats;
    }

    /**
     * @param int $numberOfSeats
     */
    public function setNumberOfSeats(int $numberOfSeats): void
    {
        $this->numberOfSeats = $numberOfSeats;
    }
}