<?php


namespace App\ViewModel\ResponseViewModel;
use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;


class ErrorResponseViewModel
{
    /**
     * @var string
     * @JMS\Type(name="integer")
     * @OA\Property(property="http_code", type="integer", description="HTTP code of error")
     */
    private int $httpCode = 500;

    /**
     * @var string
     * @JMS\Type(name="integer")
     * @OA\Property(property="internal_code", type="integer", description="Intenral code of error")
     */
    private int $internalCode;

    /**
     * @var string
     * @JMS\Type(name="string")
     * @OA\Property(property="message", type="string", description="Error message")
     */
    private string $message;

    /**
     * @return int
     */
    public function getInternalCode(): int
    {
        return $this->internalCode;
    }

    /**
     * @param int $internalCode
     */
    public function setInternalCode(int $internalCode): void
    {
        $this->internalCode = $internalCode;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string
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