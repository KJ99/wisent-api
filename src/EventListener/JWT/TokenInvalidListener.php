<?php


namespace App\EventListener\JWT;


use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;

class TokenInvalidListener extends JwtListener
{
    public function onJWTInvalid(JWTInvalidEvent $event)
    {
        $event->setResponse($this->buildFailureResponse(17, 'Access denied'));
    }
}