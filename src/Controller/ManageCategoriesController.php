<?php


namespace App\Controller;
use App\DataFactory\CategoryDataFactory;
use App\DataWarehouse\CategoryDataWarehouse;
use App\DataWarehouse\DataWarehouse;
use App\Entity\Category;
use App\ViewModel\RequestViewModel\CategoryRequestViewModel;
use App\ViewModel\SearchViewModel\CategorySearchViewModel;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @Rest\Route("/v1/manage/categories", name="manage_categories_")
 */
class ManageCategoriesController extends AbstractFOSRestController {
    /**
     * @Rest\Get("", name="list")
     * @OA\Tag(name="Manage categories")
     * @ParamConverter("params", class="App\ViewModel\SearchViewModel\CategorySearchViewModel::class", converter="in_query")
     * @OA\Response(
     *     response=200,
     *     description="Returns list of categories",
     *     @OA\JsonContent(type="array", @OA\Items(ref=@Model(type=App\ViewModel\ResponseViewModel\CategoryResponseViewModel::class)))
     * )
     */
    public function getList(Request $request, CategoryDataWarehouse $warehouse, CategorySearchViewModel $params) {
        return $this->json($warehouse->get(), 200);
    }

    /**
     * @Rest\Get("/{id}", name="particular")
     * @OA\Tag(name="Manage categories")
     * @OA\Parameter(name="id", in="path", description="Find particular category details", schema=@OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Returns single category info",
     *     @Model(type=App\ViewModel\ResponseViewModel\CategoryResponseViewModel::class)
     * )
     * @OA\Response(response=404, description="not found")
     */
    public function getParticular(CategoryDataWarehouse $warehouse) {
        return $this->json($warehouse->get(), 200);
    }

    /**
     * @Rest\Post("", name="create")
     * @OA\Tag(name="Manage categories")
     * @ParamConverter("params", class="App\ViewModel\RequestViewModel\CategoryRequestViewModel::class", converter="fos_rest.request_body")
     * @OA\RequestBody(
     *     required=true,
     *     description="Request body",
     *     @Model(type=App\ViewModel\RequestViewModel\CategoryRequestViewModel::class)
     * )
     * @OA\Response(
     *     response=201,
     *     description="Returns freshly created category",
     *     @Model(type=App\ViewModel\ResponseViewModel\CategoryResponseViewModel::class)
     * )
     */
    public function create(CategoryRequestViewModel $params, CategoryDataFactory $factory) {
        $response = $factory->create($params);
        return $this->json($response->getViewModel(), $response->getHttpCode());
    }

    /**
     * @Rest\Patch("/{category}", name="update")
     * @OA\Tag(name="Manage categories")
     * @ParamConverter("params", class="App\ViewModel\RequestViewModel\CategoryRequestViewModel::class", converter="fos_rest.request_body")
     * @OA\RequestBody(
     *     required=true,
     *     description="Request body",
     *     @Model(type=App\ViewModel\RequestViewModel\CategoryRequestViewModel::class)
     * )
     * @OA\Parameter(name="category", in="path", description="Current category id", schema=@OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Returns updated category",
     *     @Model(type=App\ViewModel\ResponseViewModel\CategoryResponseViewModel::class)
     * )
     */
    public function update(Category $category, CategoryRequestViewModel $params, CategoryDataFactory $factory) {
        $response = $factory->update($category, $params);
        return $this->json($response->getViewModel(), $response->getHttpCode());
    }

    /**
     * @Rest\Delete("/{category}", name="delete")
     * @OA\Tag(name="Manage categories")
     * @OA\Parameter(name="category", in="path", description="Category id", schema=@OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Category deleted",
     *     @OA\JsonContent(type="object", @OA\Property(property="message", type="string", example="Category deleted"), @OA\Property(property="id", type="integer"))
     * )
     */
    public function delete(Category $category, CategoryDataFactory $factory) {
        $response = $factory->delete($category);
        return $this->json($response->getViewModel(), $response->getHttpCode());
    }
}