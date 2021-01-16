<?php


namespace App\ViewModel\ResponseViewModel;
use JMS\Serializer\Annotation as JMS;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;


class SubcategoryResponseViewModel {

    /**
     * @var int
     * @JMS\Type(name="integer")
     * @OA\Property(description="ID of the subcategory", schema=@OA\Schema(type="integer"))
     */
    private int $id;

    /**
     * @var string
     * @JMS\Type(name="string")
     * @OA\Property(description="Name of the subcategory", schema=@OA\Schema(type="string"))
     */
    private string $name;

    /**
     * @var bool
     * @JMS\Type(name="boolean")
     * @OA\Property(description="Visibility status of the subcategory", schema=@OA\Schema(type="boolean"))
     */
    private bool $visible;

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