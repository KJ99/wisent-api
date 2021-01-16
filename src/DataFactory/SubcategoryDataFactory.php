<?php


namespace App\DataFactory;


use App\Entity\Subcategory;
use App\ViewModel\ResponseViewModel\SubcategoryResponseViewModel;

class SubcategoryDataFactory extends DataFactory
{

    protected function getEntityClass()
    {
        return Subcategory::class;
    }

    protected function createEntity()
    {
        return new Subcategory();
    }

    protected function prepareCreate($entity, $viewModel)
    {
        $entity->setCategory($viewModel->getCategory());
    }

    protected function getResponseClass()
    {
        return SubcategoryResponseViewModel::class;
    }

    protected function getDeleteMessage()
    {
        return "Subcategory deleted successfully";
    }
}