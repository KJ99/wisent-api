<?php


namespace App\ViewModel\SearchViewModel;
use OpenApi\Annotations as OA;
use JMS\Serializer\Annotation as JMS;


abstract class SearchViewModel implements \JsonSerializable {

    /**
     * @var bool
     * @JMS\Type("boolean")
     *
     */
    protected $cacheDisabled = false;

    /**
     * @return bool
     */
    public function isCacheDisabled(): bool
    {
        return $this->cacheDisabled;
    }

    /**
     * @param bool $cacheDisabled
     */
    public function setCacheDisabled(bool $cacheDisabled): void
    {
        $this->cacheDisabled = $cacheDisabled;
    }

}