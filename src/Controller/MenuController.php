<?php


namespace App\Controller;

use App\DataWarehouse\CategoryDataWarehouse;
use App\ViewModel\SearchViewModel\CategorySearchViewModel;
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
}