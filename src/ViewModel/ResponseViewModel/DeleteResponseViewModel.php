<?php


namespace App\ViewModel\ResponseViewModel;
use JMS\Serializer\Annotation as JMS;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;


class DeleteResponseViewModel
{
    /**
     * @var string
     * @JMS\Type(name="string")
     * @OA\Property(description="Display message", type="string", example="Item deleted successfullty")
     */
    private string $message;

    /**
     * @var int
     * @JMS\Type(name="integer")
     * @OA\Property(description="ID of the deleted item", schema=@OA\Schema(type="integer"))
     */
    private int $id;

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

}