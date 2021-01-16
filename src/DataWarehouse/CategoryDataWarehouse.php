<?php


namespace App\DataWarehouse;


use App\Entity\Category;
use App\ViewModel\ResponseViewModel\CategoryResponseViewModel;
use App\ViewModel\ResponseViewModel\ResponseViewModel;
use App\ViewModel\ResponseViewModel\SubcategoryResponseViewModel;
use App\ViewModel\SearchViewModel\CategorySearchViewModel;
use App\ViewModel\SearchViewModel\SearchViewModel;

class CategoryDataWarehouse extends DataWarehouse
{
    /**
     * @inheritDoc
     */
    protected function getCacheKey(): string
    {
        return 'categories';
    }

    protected function getResponseModelClass(): string
    {
        return CategoryResponseViewModel::class;
    }

    protected function getEntityClass(): string
    {
        return Category::class;
    }

    protected function getNotFoundMessage(): string
    {
        return 'Category not found';
    }
}