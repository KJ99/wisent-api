<?php


namespace App\ViewModel\SearchViewModel;


use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

class DishSearchViewModel extends SearchViewModel {
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
    private $visible = true;

    /**
     * @var int
     * @JMS\Type("integer")
     * @OA\Property(property="category_id", type="integer", example=1, required="false")
     *
     */
    private int $subcategoryId = 0;

    /**
     * @var bool
     * @JMS\Type("boolean")
     * @OA\Property(property="multi_currency", type="boolean", example=true, description="Should API show price in various currencies")
     *
     */
    private bool $multiCurrency = false;
    /**
     * @JMS\Type(name="string")
     */
    private string $currencies = '';

    public function __construct()
    {
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
        if($this->subcategoryId > 0) {
            $params['subcategory_id'] = $this->subcategoryId;
        }
        return $params;
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
     * @return bool
     */
    public function isMultiCurrency(): bool
    {
        return $this->multiCurrency;
    }

    /**
     * @param bool $multiCurrency
     */
    public function setMultiCurrency(bool $multiCurrency): void
    {
        $this->multiCurrency = $multiCurrency;
    }

    public function getRequestedCurrencies() {
        $requestedCurrencies = explode(',', $this->currencies);
        if(!in_array('PLN', $requestedCurrencies)) {
            $requestedCurrencies[] = 'PLN';
        }
        if($this->multiCurrency && !in_array('EUR', $requestedCurrencies)) {
            $requestedCurrencies[] = 'EUR';
        }
        return $requestedCurrencies;
    }
}