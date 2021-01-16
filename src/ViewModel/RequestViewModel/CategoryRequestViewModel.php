<?php


namespace App\ViewModel\RequestViewModel;

use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;

class CategoryRequestViewModel {
    /**
     * @var string
     * @JMS\Type(name="string")
     * @OA\Property(description="Name the category", schema=@OA\Schema(type="string"), example="Dania obiadowe")
     */
    private string $name;

    /**
     * @var bool
     * @JMS\Type(name="boolean")
     * @OA\Property(description="Visibility status of the category", schema=@OA\Schema(type="boolean"), example="true")
     *
     */
    private bool $visible = true;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

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
}