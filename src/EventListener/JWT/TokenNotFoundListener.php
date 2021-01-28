<?php


namespace App\EventListener\JWT;


use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;

class TokenNotFoundListener extends JwtListener
{
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $event->setResponse($this->buildFailureResponse(14, 'Token not found', 401));
    }
}