<?php


namespace App\Controller;
use App\DataFactory\CategoryDataFactory;
use App\DataFactory\SubcategoryDataFactory;
use App\DataWarehouse\CategoryDataWarehouse;
use App\DataWarehouse\DataWarehouse;
use App\DataWarehouse\SubcategoryDataWarehouse;
use App\Entity\Category;
use App\Entity\Subcategory;
use App\ViewModel\RequestViewModel\CategoryRequestViewModel;
use App\ViewModel\RequestViewModel\SubcategoryRequestViewModel;
use App\ViewModel\SearchViewModel\CategorySearchViewModel;
use App\ViewModel\SearchViewModel\SubcategorySearchViewModel;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @Rest\Route("/v1/manage/subcategories", name="manage_subcategories_")
 */
class ManageSubcategoriesController extends AbstractFOSRestController {
    /**
     * @Rest\Get("", name="list")
     * @OA\Tag(name="Manage subcategories")
     * @ParamConverter("params", class="App\ViewModel\SearchViewModel\SubcategorySearchViewModel::class", converter="in_query")'
     * @OA\Parameter(name="visible", in="query", schema=@OA\Schema(type="boolean"), example=true)
     * @OA\Parameter(name="category_id", in="query", schema=@OA\Schema(type="integer"), example=0)
     * @OA\Response(
     *     response=200,
     *     description="Returns list of subcategories",
     *     @OA\JsonContent(type="array", @OA\Items(ref=@Model(type=App\ViewModel\ResponseViewModel\SubcategoryResponseViewModel::class)))
     * )
     */
    public function getList(SubcategorySearchViewModel $params, SubcategoryDataWarehouse $warehouse) {
        $warehouse->setParams($params);
        return $this->json($warehouse->get(), 200);
    }

    /**
     * @Rest\Get("/{id}", name="particular")
     * @OA\Tag(name="Manage subcategories")
     * @OA\Parameter(name="id", in="path", description="Find particular subcategory details", schema=@OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Returns single subcategory info",
     *     @Model(type=App\ViewModel\ResponseViewModel\SubcategoryResponseViewModel::class)
     * )
     */
    public function getParticular(SubcategoryDataWarehouse $warehouse) {
        return $this->json($warehouse->get(), 200);
    }

    /**
     * @Rest\Post("", name="create")
     * @OA\Tag(name="Manage subcategories")
     * @ParamConverter("params", class="App\ViewModel\RequestViewModel\SubcategoryRequestViewModel::class", converter="fos_rest.request_body")
     * @OA\RequestBody(
     *     required=true,
     *     description="Request body",
     *     @OA\JsonContent(type="object",
     *     @OA\Property(property="name", description="Name the subsubcategory", schema=@OA\Schema(type="string"), example="Piwa"),
     *     @OA\Property(property="visible", description="Visibility status of the subcategory", schema=@OA\Schema(type="boolean"), example="true"),
     *     @OA\Property(property="category_id", property="category_id", description="ID of the category", type="integer")
     * )
     * )
     * @OA\Response(
     *     response=201,
     *     description="Returns freshly created category",
     *     @Model(type=App\ViewModel\ResponseViewModel\SubcategoryResponseViewModel::class)
     * )
     */
    public function create(Request $request, SubcategoryRequestViewModel $params, SubcategoryDataFactory $factory, ?Category $category) {
        $params->setCategory($category);
        $response = $factory->create($params);
        return $this->json($response->getViewModel(), $response->getHttpCode());
    }

    /**
     * @Rest\Patch("/{subcategory}", name="update")
     * @OA\Tag(name="Manage subcategories")
     * @ParamConverter("params", class="App\ViewModel\RequestViewModel\SubcategoryRequestViewModel::class", converter="fos_rest.request_body")
     * @OA\RequestBody(
     *     required=true,
     *     description="Request body",
     *     @OA\JsonContent(type="object",
     *      @OA\Property(property="name", type="string"),
     *      @OA\Property(property="visible", type="boolean")
     * )
     * )
     * @OA\Parameter(name="subcategory", in="path", description="Current subcategory id", schema=@OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Returns updated category",
     *     @Model(type=App\ViewModel\ResponseViewModel\SubcategoryResponseViewModel::class)
     * )
     */
    public function update(Subcategory $subcategory, SubcategoryRequestViewModel $params, SubcategoryDataFactory $factory) {
        $params->setCategory($subcategory->getCategory());
        $response = $factory->update($subcategory, $params);
        return $this->json($response->getViewModel(), $response->getHttpCode());
    }

    /**
     * @Rest\Delete("/{subcategory}", name="delete")
     * @OA\Tag(name="Manage subcategories")
     * @OA\Parameter(name="subcategory", in="path", description="Subcategory id", schema=@OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Subcategory deleted",
     *     @OA\JsonContent(type="object", @OA\Property(property="message", type="string", example="Subcategory deleted"), @OA\Property(property="id", type="integer"))
     * )
     */
    public function delete(Subcategory $subcategory, SubcategoryDataFactory $factory) {
        $response = $factory->delete($subcategory);
        return $this->json($response->getViewModel(), $response->getHttpCode());
    }
}