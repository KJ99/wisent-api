<?php


namespace App\DataWarehouse;


use App\Entity\Reservation;
use App\ViewModel\ResponseViewModel\ReservationResponseViewModel;

class ReservationDataWarehouse extends DataWarehouse
{

    protected function fetchList(): array
    {
        return $this->em->getRepository($this->getEntityClass())->findFuture();
    }

    /**
     * @inheritDoc
     */
    protected function getCacheKey(): string
    {
        return 'reservations';
    }

    protected function getResponseModelClass(): string
    {
        return ReservationResponseViewModel::class;
    }

    protected function getEntityClass(): string
    {
        return Reservation::class;
    }

    protected function shouldUseCache(): bool
    {
        return false;
    }
}