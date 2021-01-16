<?php


namespace App\ViewModel\RequestViewModel;
use App\Entity\Picture;
use App\Entity\Subcategory;
use JMS\Serializer\Annotation as JMS;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

class DishRequestViewModel {

    /**
     * @var string
     * @JMS\Type(name="string")
     * @OA\Property(property="name", type="string", description="Name of the dish", example="Spaghetti")
     */
    private string $name;

    /**
     * @var string
     * @JMS\Type(name="string")
     * @OA\Property(property="description", type="string", description="Descripton of the dish", example="30ml of coooooool vodka")
     */
    private string $description;

    private float $priceInPln = 0;

    /**
     * @var integer
     * @JMS\Type(name="integer")
     * @OA\Property(property="price", type="integer", description="Price of the dish in Polish Grosz", example="20")
     */
    private int $price = 0;

    /**
     * @var integer
     * @JMS\Type(name="integer")
     * @OA\Property(property="subcategory_id", type="integer", description="Id of the dish subcategory", example="1")
     */
    private int $subcategoryId = 0;

    /**
     * @var integer
     * @JMS\Type(name="integer")
     * @OA\Property(property="picture_id", type="integer", description="Id of the dish picture", example="1")
     */
    private int $pictureId = 0;

    /**
     * @var Subcategory
     * @JMS\Exclude
     */
    private ?Subcategory $subcategory = null;

    private ?Picture $picture = null;

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
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getSubcategoryId(): int
    {
        return $this->subcategoryId;
    }

    /**
     * @param int $subcategoryId
     */
    public function setSubcategoryId(int $subcategoryId): void
    {
        $this->subcategoryId = $subcategoryId;
    }

    /**
     * @return int
     */
    public function getPictureId(): int
    {
        return $this->pictureId;
    }

    /**
     * @param int $pictureId
     */
    public function setPictureId(int $pictureId): void
    {
        $this->pictureId = $pictureId;
    }

    /**
     * @return Subcategory
     */
    public function getSubcategory(): Subcategory
    {
        return $this->subcategory;
    }

    /**
     * @param Subcategory $subcategory
     */
    public function setSubcategory(Subcategory $subcategory): void
    {
        $this->subcategory = $subcategory;
    }

    /**
     * @return Picture|null
     */
    public function getPicture(): ?Picture
    {
        return $this->picture;
    }

    /**
     * @param Picture|null $picture
     */
    public function setPicture(?Picture $picture): void
    {
        $this->picture = $picture;
    }

    /**
     * @return float
     */
    public function getPriceInPln(): float
    {
        return $this->priceInPln;
    }

    /**
     * @param float $priceInPln
     */
    public function setPriceInPln(float $priceInPln): void
    {
        $this->priceInPln = $priceInPln;
    }
}