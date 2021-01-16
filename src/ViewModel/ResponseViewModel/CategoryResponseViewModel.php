<?php


namespace App\ViewModel\ResponseViewModel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as JMS;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

class CategoryResponseViewModel
{

    /**
     * @var int
     * @JMS\Type(name="integer")
     * @OA\Property(description="ID of the category", schema=@OA\Schema(type="integer"))
     */
    private int $id;

    /**
     * @var string
     * @JMS\Type(name="string")
     * @OA\Property(description="Name of the category", schema=@OA\Schema(type="string"))
     */
    private string $name;

    /**
     * @var bool
     * @JMS\Type(name="boolean")
     * @OA\Property(description="Visibility status of the category", schema=@OA\Schema(type="boolean"))
     */
    private bool $visible;

    /**
     * @var ArrayCollection
     * @JMS\Type(name="ArrayCollection<App\ViewModel\ResponseViewModel\SubcategoryResponseViewModel>")
     * @OA\Property(property="subcategory", type="array", items=@OA\Items(ref=@Model(type=App\ViewModel\ResponseViewModel\SubcategoryResponseViewModel::class))))
     */
    private ArrayCollection $subcategories;

    public function __construct() {
        $this->subcategories = new ArrayCollection();
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
     */
    public function getSubcategories(): ArrayCollection
    {
        return $this->subcategories;
    }

    /**
     * @param ArrayCollection $subcategories
     */
    public function setSubcategories(ArrayCollection $subcategories): void
    {
        $this->subcategories = $subcategories;
    }

}