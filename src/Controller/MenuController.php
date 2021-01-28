<?php


namespace App\Controller;

use App\DataWarehouse\CategoryDataWarehouse;
use App\DataWarehouse\DishDataWarehouse;
use App\ViewModel\SearchViewModel\CategorySearchViewModel;
use App\ViewModel\SearchViewModel\DishSearchViewModel;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use App\Extension\QueryStringParamsConverter;

/**
 * @Rest\Route("/v1/menu", name="menu_")
 */
class MenuController extends AbstractController {

    /**
     * @Rest\Get("/categories", name="categories_list")
     * @ParamConverter("params", class="App\ViewModel\SearchViewModel\CategorySearchViewModel::class", converter="in_query")
     * @OA\Tag(name="Menu")
     * @OA\Parameter(name="cacheDisabled", in="query", example="false", description="Disable cache for that request", schema=@OA\Schema(type="boolean"))
     */
    public function getCategories(CategorySearchViewModel $params, CategoryDataWarehouse $dataWarehouse) {
        $params->setVisible(true);
        $dataWarehouse->setParams($params);
        $dataWarehouse->setUser($this->getUser());
        return $this->json($dataWarehouse->get(), 200);
    }

    /**
     * @Rest\Get("", name="list")
     * @OA\Tag(name="Menu")
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
    public function getDishes(DishSearchViewModel $params, DishDataWarehouse $warehouse) {
        $warehouse->setParams($params);
        return $this->json($warehouse->get(), 200);
    }
}