<?php


namespace App\DataFactory;


use App\Entity\Category;
use App\ViewModel\ResponseViewModel\CategoryResponseViewModel;

class CategoryDataFactory extends DataFactory
{

    protected function getEntityClass()
    {
        return Category::class;
    }

    protected function createEntity()
    {
        return new Category();
    }

    protected function getResponseClass()
    {
        return CategoryResponseViewModel::class;
    }

    protected function getDeleteMessage()
    {
        return "Category deleted successfully";
    }
}