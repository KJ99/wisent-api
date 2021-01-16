<?php


namespace App\Controller;

use App\DataFactory\DishDataFactory;
use App\DataFactory\SubcategoryDataFactory;
use App\DataWarehouse\DishDataWarehouse;
use App\DataWarehouse\SubcategoryDataWarehouse;
use App\Entity\Category;
use App\Entity\Dish;
use App\Entity\Picture;
use App\Entity\Subcategory;
use App\ViewModel\RequestViewModel\DishRequestViewModel;
use App\ViewModel\RequestViewModel\SubcategoryRequestViewModel;
use App\ViewModel\SearchViewModel\DishSearchViewModel;
use App\ViewModel\SearchViewModel\SubcategorySearchViewModel;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Model;


/**
 * @Rest\Route("/v1/manage/dishes", name="manage_dishes_")
 */
class ManageDishesController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("", name="list")
     * @OA\Tag(name="Manage dishes")
     * @ParamConverter("params", class="App\ViewModel\SearchViewModel\DishSearchViewModel::class", converter="in_query")'
     * @OA\Parameter(name="visible", in="query", schema=@OA\Schema(type="boolean"), example=true)
     * @OA\Parameter(name="subcategory_id", in="query", schema=@OA\Schema(type="integer"), example=0)
     * @OA\Parameter(name="multi_currency", in="query", schema=@OA\Schema(type="boolean"), example=1)
     * @OA\Parameter(name="currencies", in="query", example="EUR,PLN", description="List of requested currencies codes, divided by comma")
     * @OA\Response(
     *     response=200,
     *     description="Returns list of dishes",
     *     @OA\JsonContent(type="array", @OA\Items(ref=@Model(type=App\ViewModel\ResponseViewModel\DishResponseViewModel::class)))
     * )
     */
    public function getList(DishSearchViewModel $params, DishDataWarehouse $warehouse) {
        $warehouse->setParams($params);
        return $this->json($warehouse->get(), 200);
    }

    /**
     * @Rest\Get("/{id}", name="particular")
     * @OA\Tag(name="Manage dishes")
     * @OA\Parameter(name="id", in="path", description="Find particular dish details", schema=@OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Returns single dish info",
     *     @Model(type=App\ViewModel\ResponseViewModel\DishResponseViewModel::class)
     * )
     */
    public function getParticular(DishDataWarehouse $warehouse) {
        return $this->json($warehouse->get(), 200);
    }

    /**
     * @Rest\Post("", name="create")
     * @OA\Tag(name="Manage dishes")
     * @ParamConverter("params", class="App\ViewModel\RequestViewModel\DishRequestViewModel::class", converter="fos_rest.request_body")
     * @OA\RequestBody(
     *     required=true,
     *     description="Request body",
     *     @OA\JsonContent(type="object",
     *      @OA\Property(property="name", type="string", description="Name of the dish", example="Spaghetti"),
     *      @OA\Property(property="description", type="string", description="Descripton of the dish", example="30ml of coooooool vodka"),
     *      @OA\Property(property="price_in_pln", type="float", description="Price of the dish in PLN", example=20.31),
     *      @OA\Property(property="subcategory_id", type="integer", description="Id of the dish subcategory", example=1),
     *      @OA\Property(property="picture_id", type="integer", description="Id of the dish picture", example=1)
     * )
     * )
     * @OA\Response(
     *     response=201,
     *     description="Returns freshly created dish",
     *     @Model(type=App\ViewModel\ResponseViewModel\DishResponseViewModel::class)
     * )
     */
    public function create(DishRequestViewModel $params, DishDataFactory $factory, ?Subcategory $subcategory, ?Picture $picture) {
        $params->setSubcategory($subcategory);
        $params->setPicture($picture);
        $response = $factory->create($params);
        return $this->json($response->getViewModel(), $response->getHttpCode());
    }

    /**
     * @Rest\Patch("/{dish}", name="update")
     * @OA\Tag(name="Manage dishes")
     * @ParamConverter("params", class="App\ViewModel\RequestViewModel\DishRequestViewModel::class", converter="fos_rest.request_body")
     * @OA\RequestBody(
     *     required=true,
     *     description="Request body",
     *     @OA\JsonContent(type="object",
     *      @OA\Property(property="name", type="string", description="Name of the dish", example="Spaghetti"),
     *      @OA\Property(property="description", type="string", description="Descripton of the dish", example="30ml of coooooool vodka"),
     *      @OA\Property(property="price_in_pln", type="float", description="Price of the dish in PLN", example=20.31),
     *      @OA\Property(property="subcategory_id", type="integer", description="Id of the dish subcategory", example=1),
     *      @OA\Property(property="picture_id", type="integer", description="Id of the dish picture", example=1)
     * )
     * )
     * @OA\Parameter(name="dish", in="path", description="Dish id", schema=@OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Returns updated dish",
     *     @Model(type=App\ViewModel\ResponseViewModel\DishResponseViewModel::class)
     * )
     */
    public function update(Dish $dish, DishRequestViewModel $params, DishDataFactory $factory, ?Picture $picture) {
        $params->setSubcategory($dish->getSubcategory());
        $params->setPicture($picture);
        $response = $factory->update($dish, $params);
        return $this->json($response->getViewModel(), $response->getHttpCode());
    }

    /**
     * @Rest\Delete("/{dish}", name="delete")
     * @OA\Tag(name="Manage dishes")
     * @OA\Parameter(name="dish", in="path", description="Dish id", schema=@OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Dish deleted",
     *     @OA\JsonContent(type="object", @OA\Property(property="message", type="string", example="Dish deleted"), @OA\Property(property="id", type="integer"))
     * )
     */
    public function delete(Dish $dish, DishDataFactory $factory) {
        $response = $factory->delete($dish);
        return $this->json($response->getViewModel(), $response->getHttpCode());
    }
}