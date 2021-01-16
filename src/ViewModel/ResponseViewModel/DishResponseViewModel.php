<?php


namespace App\ViewModel\ResponseViewModel;

use JMS\Serializer\Annotation as JMS;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

class DishResponseViewModel {

    /**
     * @var string
     * @JMS\Type(name="string")
     * @OA\Property(property="name", type="string", description="")
     */
    private string $name;

    /**
     * @var string
     * @JMS\Type(name="string")
     * @OA\Property(property="description", type="string", description="")
     */
    private string $description;

    /**
     * @var bool
     * @JMS\Type(name="boolean")
     * @OA\Property(property="visible", type="boolean", description="")
     */
    private bool $visible;

    /**
     * @var float
     * @JMS\Type(name="float")
     * @OA\Property(property="base_price", type="number", description="")
     */
    private float $basePrice;

    /**
     * @var array
     * @JMS\Type(name="array")
     * @OA\Property(property="converted_price", type="object", schema=@OA\Schema(type="object", @OA\Property(property="EUR", type="string", example="2.49")))
     */
    private array $convertedPrice = [];

    /**
     * @var string
     * @JMS\Type(name="string")
     * @OA\Property(property="picture", type="string", description="")
     */
    private string $picture;

    /**
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     */
    public function setPicture(string $picture): void
    {
        $this->picture = $picture;
    }

    /**
     * @return array
     */
    public function getConvertedPrice(): array
    {
        return $this->convertedPrice;
    }

    /**
     * @param array $convertedPrice
     */
    public function setConvertedPrice(array $convertedPrice): void
    {
        $this->convertedPrice = $convertedPrice;
    }

    /**
     * @return float
     */
    public function getBasePrice(): float
    {
        return $this->basePrice;
    }

    /**
     * @param float $basePrice
     */
    public function setBasePrice(float $basePrice): void
    {
        $this->basePrice = $basePrice;
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

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

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
}