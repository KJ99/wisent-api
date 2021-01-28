<?php


namespace App\EventListener\JWT;


use ApiPlatform\Core\Api\UrlGeneratorInterface;
use App\ViewModel\ResponseViewModel\ErrorResponseViewModel;
use JMS\Serializer\SerializerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class JwtExpiredListener extends JwtListener
{
    public function onJWTExpired(JWTExpiredEvent $event)
    {
        $event->setResponse($this->buildFailureResponse(16, 'Token expired'));
    }
}