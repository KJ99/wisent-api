<?php


namespace App\Exception;


use Throwable;

class ApiException extends \Exception
{
    private int $httpCode;

    public function __construct($message = "", $code = 0, int $httpCode = 500, Throwable $previous = null)
    {
        $this->httpCode = $httpCode;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * @param int $httpCode
     */
    public function setHttpCode(int $httpCode): void
    {
        $this->httpCode = $httpCode;
    }
}