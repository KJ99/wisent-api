<?php


namespace App\ViewModel\ResponseViewModel;

use JMS\Serializer\Annotation as JMS;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

class AvailablePlacesResponseViewModel
{
    /**
     * @var string
     * @JMS\Type("string")
     * @OA\Property(property="date", type="string", example="2021-01-30")
     */
    private string $date;

    /**
     * @var integer
     * @JMS\Type("integer")
     * @OA\Property(property="available_places", type="integer", example=8)
     */
    private int $availablePlaces;

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
    public function getAvailablePlaces(): int
    {
        return $this->availablePlaces;
    }

    /**
     * @param int $availablePlaces
     */
    public function setAvailablePlaces(int $availablePlaces): void
    {
        $this->availablePlaces = $availablePlaces;
    }
}