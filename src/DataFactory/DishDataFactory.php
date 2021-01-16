<?php


namespace App\DataFactory;


use ApiPlatform\Core\Api\UrlGeneratorInterface;
use App\Entity\Dish;
use App\Entity\Subcategory;
use App\Service\FileService;
use App\ViewModel\ResponseViewModel\DishResponseViewModel;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DishDataFactory extends DataFactory
{
    private FileService $fileService;
    private UrlGeneratorInterface $router;

    public function __construct(UrlGeneratorInterface $router, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator, FileService $fileService)
    {
        $this->fileService = $fileService;
        $this->router = $router;
        parent::__construct($em, $serializer, $validator);
    }

    protected function getDeleteMessage()
    {
        return 'Dish deleted successfully';
    }

    protected function getEntityClass()
    {
        return Dish::class;
    }

    protected function getResponseClass()
    {
        return DishResponseViewModel::class;
    }

    protected function createEntity()
    {
        return new Dish();
    }

    protected function prepareCreate($entity, $viewModel)
    {
        $entity->setPrice(intval($viewModel->getPriceInPln() * 100));
        $entity->setSubcategory($viewModel->getSubcategory());
    }

    protected function prepareUpdate($original, $updated, $viewModel)
    {
        $updated->setPrice(intval($viewModel->getPriceInPln() * 100));
        if($updated->getPicture() == null) {
            $updated->setPicture($original->getPicture());
        }
    }

    protected function postUpdate($original, $updated)
    {
        if($original->getPicture()->getId() != $updated->getPicture()->getId()) {
            $this->fileService->deleteFileAsync($original->getPicture());
        }
    }

    protected function postDelete($entity)
    {
        $this->fileService->deleteFileAsync($entity->getPicture());
    }

    protected function mapResponse($entity) {
        $json = $this->serializer->serialize($entity, 'json');
        $assoc = json_decode($json, true);
        $assoc['base_price'] = floatval($assoc['price']) / 100;
        $assoc['picture'] = $this->router->generate('resources_pictures_dish', ['id' => $entity->getId()], UrlGeneratorInterface::ABS_URL);;
        return $this->serializer->deserialize(json_encode($assoc), $this->getResponseClass(), 'json');
    }
}