<?php


namespace App\ViewModel\SearchViewModel;
use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;


class ReservationSearchViewModel extends SearchViewModel
{
    /**
     * @var int
     * @JMS\Type("integer")
     * @OA\Property(property="id", type="integer", example=1, required="false")
     */
    private int $id = 0;

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $params = [];
        if($this->id > 0) {
            $params['id'] = $this->id;
        }
        return $params;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}