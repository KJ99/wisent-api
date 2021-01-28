<?php


namespace App\ViewModel\RequestViewModel;


use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequestViewModel
{
    /**
     * @var string
     * @Assert\Email(message="Provided email address is not valid")
     * @JMS\Type(name="string")
     */
    private string $email;

    /**
     * @var string
     * @JMS\Type(name="string")
     * @Assert\Length(min=3, minMessage="username should have at least 3 characters")
     */
    private string $username;

    /**
     * @var string
     * @Assert\Length(min=6, minMessage="password should have at least 6 characters")
     * @JMS\Type(name="string")
     */
    private string $password;

    /**
     * @var string
     * @Assert\Expression("this.getConfirmPassword() == this.getPassword()", message="Passwords are not the same")
     */
    private string $confirmPassword;

    /**
     * @var array
     * @JMS\Type(name="array<string>")
     */
    private array $roles = [];

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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }

    /**
     * @param string $confirmPassword
     */
    public function setConfirmPassword(string $confirmPassword): void
    {
        $this->confirmPassword = $confirmPassword;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
}