<?php


namespace App\ViewModel\ResponseViewModel;

use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;

class UserResponseViewModel
{
    /**
     * @var string
     * @JMS\Type(name="string")
     */
    private string $username;


    /**
     * @var string
     * @JMS\Type(name="string")
     */
    private string $avatar;

    /**
     * @var bool
     * @JMS\Type(name="boolean")
     */
    private bool $admin;

    /**
     * @var bool
     * @JMS\Type(name="boolean")
     */
    private bool $moderator;

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->admin;
    }

    /**
     * @param bool $admin
     */
    public function setAdmin(bool $admin): void
    {
        $this->admin = $admin;
    }

    /**
     * @return bool
     */
    public function isModerator(): bool
    {
        return $this->moderator;
    }

    /**
     * @param bool $moderator
     */
    public function setModerator(bool $moderator): void
    {
        $this->moderator = $moderator;
    }
}