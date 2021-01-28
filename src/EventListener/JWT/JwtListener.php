<?php


namespace App\EventListener\JWT;


use App\ViewModel\ResponseViewModel\ErrorResponseViewModel;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class JwtListener
{

    protected SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    protected function buildFailureResponse(int $internalCode, string $message, int $httpCode = 403) {
        $model = new ErrorResponseViewModel();
        $model->setHttpCode($httpCode);
        $model->setInternalCode($internalCode);
        $model->setMessage($message);
        $responseJson = $this->serializer->serialize($model, 'json');
        return new JsonResponse(json_decode($responseJson, true), $httpCode);
    }
}