<?php


namespace App\ViewModel\ResponseViewModel;

use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;

class LoginResponseViewModel
{

    /**
     * @var string
     * @JMS\Type(name="string")
     */
    private string $token;

    private UserResponseViewModel $user;

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return UserResponseViewModel
     */
    public function getUser(): UserResponseViewModel
    {
        return $this->user;
    }

    /**
     * @param UserResponseViewModel $user
     */
    public function setUser(UserResponseViewModel $user): void
    {
        $this->user = $user;
    }
}