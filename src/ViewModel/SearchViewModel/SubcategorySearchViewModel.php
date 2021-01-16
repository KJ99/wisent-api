<?php


namespace App\ViewModel\SearchViewModel;
use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;


class SubcategorySearchViewModel extends SearchViewModel {

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
     * @var int
     * @JMS\Type("integer")
     * @OA\Property(property="category_id", type="integer", example=1, required="false")
     *
     */
    private int $categoryId = 0;

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
        if($this->categoryId > 0) {
            $params['category_id'] = $this->categoryId;
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

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @param int $category_id
     */
    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }
}