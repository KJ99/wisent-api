<?php


namespace App\ViewModel\ResponseViewModel;
use JMS\Serializer\Annotation as JMS;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;


class UploadResponseViewModel
{
    /**
     * @var int
     * @JMS\Type(name="integer")
     * @OA\Property(property="id", description="File reference")
     */
    private int $id;

    /**
     * @var string
     * @JMS\Type(name="string")
     * @OA\Property(property="message")
     */
    private string $message;

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