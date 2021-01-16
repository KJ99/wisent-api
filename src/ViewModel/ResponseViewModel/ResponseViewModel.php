<?php


namespace App\ViewModel\ResponseViewModel;


abstract class ResponseViewModel implements \JsonSerializable {
    const CUSTOMER_RESPONSE_TYPE = 1;
    const ADMIN_RESPONSE_TYPE = 2;

    protected $responseType = self::CUSTOMER_RESPONSE_TYPE;

    public function jsonSerialize()
    {
        return $this->responseType == self::ADMIN_RESPONSE_TYPE ? $this->serializeForAdmin() : $this->serializeForCustomer();
    }

    /**
     * @return int
     */
    public function getResponseType(): int
    {
        return $this->responseType;
    }

    /**
     * @param int $responseType
     */
    public function setResponseType(int $responseType): void
    {
        $this->responseType = $responseType;
    }


    protected abstract function serializeForAdmin(): array;

    protected abstract function serializeForCustomer(): array;

}