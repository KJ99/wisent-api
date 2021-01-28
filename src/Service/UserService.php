<?php


namespace App\Service;


use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\User;
use App\Exception\ExceptionResolver;
use App\Result\Result;
use App\ViewModel\RequestViewModel\UserRequestViewModel;
use App\ViewModel\ResponseViewModel\RegistrationResponseViewModel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private FileService $fileService;
    private ValidatorInterface $validator;
    private UserPasswordEncoderInterface $encoder;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em, FileService $fileService, ValidatorInterface $validator, UserPasswordEncoderInterface $encoder)
    {
        $this->fileService = $fileService;
        $this->validator = $validator;
        $this->encoder = $encoder;
        $this->em = $em;
    }


    public function getUserRoles(string $roleName): array {
        $roles = [];
        switch ($roleName) {
            case 'moderator':
                $roles = ['ROLE_MODERATOR'];
                break;
            case 'admin':
                $roles = ['ROLE_MODERATOR', 'ROLE_ADMIN'];
                break;
        }
        return $roles;
    }

    public function createUser(UserRequestViewModel $model): Result {
        $result = new Result();
        $user = $this->createEntity($model);
        try {
            $this->validate($model, $user);
            $this->em->persist($user->getPicture());
            $this->em->persist($user);
            $this->em->flush();
            $result->setHttpCode(201);
            $response = new RegistrationResponseViewModel();
            $response->setMessage('User created successfully');
            $result->setViewModel($response);
        }catch (\Throwable $e) {
            dump($e);
            $error = ExceptionResolver::resolveError($e);
            $result->setHttpCode($error->getHttpCode());
            $result->setViewModel($error);
        }
        return $result;
    }

    private function createEntity(UserRequestViewModel $model) {
        $user = new User();
        $user->setEmail($model->getEmail());
        $user->setUsername($model->getUsername());
        $user->setRoles($model->getRoles());
        $user->setPicture($this->fileService->getDefaultUserAvatar());
        $user->setPassword($this->encoder->encodePassword($user, $model->getPassword()));
        return $user;
    }

    private function validate(UserRequestViewModel $model, User $user) {
        $this->validator->validate($model);
        $this->validator->validate($user);
    }
}