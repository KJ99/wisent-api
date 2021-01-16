<?php


namespace App\DataFactory;


use App\Entity\Reservation;
use App\ViewModel\ResponseViewModel\ReservationResponseViewModel;

class ReservationDataFactory extends DataFactory
{

    protected function getDeleteMessage()
    {
        return 'Reservation deleted';
    }

    protected function getEntityClass()
    {
        return Reservation::class;
    }

    protected function getResponseClass()
    {
        return ReservationResponseViewModel::class;
    }

    protected function createEntity()
    {
        return new Reservation();
    }

    protected function prepareCreate($entity, $viewModel)
    {
        $contact = $viewModel->getContact();
        if($contact != null && $contact->getId() == null) {
            $this->em->persist($contact);
            $this->em->flush();
        }
        $entity->setDateOfReservation(new \DateTime($viewModel->getDate()));
        $entity->setContact($contact);
        $entity->setNumber(base64_encode(time() . random_bytes(8)));
    }
}