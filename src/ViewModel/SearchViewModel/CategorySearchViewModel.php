<?php


namespace App\ViewModel\SearchViewModel;
use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;


class CategorySearchViewModel extends SearchViewModel {

    /**
     * @var int
     * @JMS\Type("integer")
     * @OA\Property(property="id", type="integer", example=1, required="false")
     */
    private int $id = 0;

    /**
     * @var bool
     * @JMS\Type("boolean")
     * @OA\Property(property="visible", type="boolean", example=true, required="false")
     *
     */
    private $visible;

    /**
     * @return bool
     */
    public function isVisible(): bool
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     */
    public function setVisible(bool $visible): void
    {
        $this->visible = $visible;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $params = [];
        if($this->visible != null) {
            $params['visible'] = $this->visible;
        }
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