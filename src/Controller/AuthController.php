<?php


namespace App\Controller;


use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;

/**
 * Class AuthController
 * @package App\Controller
 * @Rest\Route("/v1/auth", name="auth_")
 * @OA\Tag(name="Authentication")
 */
class AuthController
{
    /**
     * @Rest\Post("/login", name="login")
     * @OA\RequestBody(
     *     required=true,
     *     description="Request body",
     *     @OA\JsonContent(type="object",
     *      @OA\Property(property="username", type="string", description="Username or email address", example="admion"),
     *      @OA\Property(property="password", type="string", description="User password", example="admin"),
     * )
     * )
     */
    public function login() {

    }
}