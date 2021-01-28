<?php


namespace App\ViewModel\ResponseViewModel;
use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;


class RegistrationResponseViewModel
{
    private string $message;

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
}