<?php


namespace App\ViewModel\RequestViewModel;

use App\Entity\Category;
use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;

class SubcategoryRequestViewModel {
    /**
     * @var string
     * @JMS\Type(name="string")
     * @OA\Property(description="Name the subsubcategory", schema=@OA\Schema(type="string"), example="Dania obiadowe")
     */
    private string $name;

    /**
     * @var bool
     * @JMS\Type(name="boolean")
     * @OA\Property(description="Visibility status of the subcategory", schema=@OA\Schema(type="boolean"), example="true")
     *
     */
    private bool $visible = true;

    /**
     * @var int
     * @JMS\Type(name="integer")
     * @OA\Property(property="category_id", description="ID of the category", type="integer")
     */
    private int $categoryId = 0;

    /**
     * @var Category|null
     * @JMS\Exclude
     */
    private ?Category $category;

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
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     */
    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }
}