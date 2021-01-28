<?php


namespace App\EventListener\JWT;


use ApiPlatform\Core\Api\UrlGeneratorInterface;
use App\ViewModel\ResponseViewModel\ErrorResponseViewModel;
use JMS\Serializer\SerializerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthenticationFailureListener extends JwtListener
{
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $event->setResponse($this->buildFailureResponse(11, 'Bad credentails'));
    }
}