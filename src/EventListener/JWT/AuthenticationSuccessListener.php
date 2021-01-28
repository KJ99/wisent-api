<?php


namespace App\EventListener\JWT;


use ApiPlatform\Core\Api\UrlGeneratorInterface;
use App\Entity\User;
use App\Result\Result;
use App\ViewModel\ResponseViewModel\ErrorResponseViewModel;
use App\ViewModel\ResponseViewModel\LoginResponseViewModel;
use App\ViewModel\ResponseViewModel\UserResponseViewModel;
use JMS\Serializer\SerializerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener extends JwtListener
{
    private UrlGeneratorInterface $router;

    public function __construct(UrlGeneratorInterface $router, SerializerInterface $serializer)
    {
        $this->router = $router;
        parent::__construct($serializer);
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event) {
        $data = $event->getData();
        $result = $this->getAuthResult($event->getUser(), $data['token']);
        $resultJson = $this->serializer->serialize($result->getViewModel(), 'json');
        $event->getResponse()->setStatusCode($result->getHttpCode());
        $event->setData(json_decode($resultJson, true));
    }

    private function getAuthResult(User $user, string $token): Result {
        $result = new Result();
        if(!$user->getVerified()) {
            $result = $this->getUserNotVerifiedResult();
        } else if(!$user->getActive()) {
            $result = $this->getUserNotActiveResult();
        } else {
            $result = $this->getTokenResult($user, $token);
        }
        return $result;
    }

    private function getUserNotVerifiedResult() {
        $errorModel = new ErrorResponseViewModel();
        $errorModel->setHttpCode(403);
        $errorModel->setMessage('Account is not verified');
        $errorModel->setInternalCode(13);
        $result = new Result();
        $result->setHttpCode($errorModel->getHttpCode());
        $result->setViewModel($errorModel);
        return $result;
    }

    private function getUserNotActiveResult() {
        $errorModel = new ErrorResponseViewModel();
        $errorModel->setHttpCode(403);
        $errorModel->setMessage('Account is blocked');
        $errorModel->setInternalCode(12);
        $result = new Result();
        $result->setHttpCode($errorModel->getHttpCode());
        $result->setViewModel($errorModel);
        return $result;

    }

    private function getTokenResult(User $user, string $token) {
        $avatarUrl = $this->router->generate(
            'resources_users_avatar',
            [
                'id' => $user->getId()
            ], UrlGeneratorInterface::ABS_URL
        );
        $result = new Result();
        $userModel = new UserResponseViewModel();
        $userModel->setUsername($user->getUsername());
        $userModel->setAvatar($avatarUrl);
        $userModel->setAdmin($user->isAdmin());
        $userModel->setModerator($user->isModerator());

        $model = new LoginResponseViewModel();
        $model->setUser($userModel);
        $model->setToken($token);
        $result->setViewModel($model);
        return $result;
    }

}