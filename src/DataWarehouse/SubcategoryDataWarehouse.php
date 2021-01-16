<?php


namespace App\DataWarehouse;


use App\Entity\Subcategory;
use App\ViewModel\ResponseViewModel\SubcategoryResponseViewModel;

class SubcategoryDataWarehouse extends DataWarehouse
{

    protected function fetchList(): array
    {
        $searchParams = $this->params != null ? $this->params->jsonSerialize() : [];
        return $this->em->getRepository(Subcategory::class)->findBySearchParams($searchParams);
    }

    protected function fetchParticular()
    {
        return $this->em->getRepository(Subcategory::class)->findOneBy(['id' => $this->params->getId()]);
    }

    /**
     * @inheritDoc
     */
    protected function getCacheKey(): string
    {
        return 'subcategories';
    }

    protected function getResponseModelClass(): string
    {
        return SubcategoryResponseViewModel::class;
    }

    protected function getEntityClass(): string
    {
        return Subcategory::class;
    }
}