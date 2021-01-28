<?php


namespace App\EventListener;


use App\DataWarehouse\CategoryDataWarehouse;
use App\DataWarehouse\DataWarehouse;
use App\Entity\Category;
use App\ViewModel\SearchViewModel\CategorySearchViewModel;
use App\ViewModel\SearchViewModel\ReservationSearchViewModel;
use App\ViewModel\SearchViewModel\SubcategorySearchViewModel;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelInterface;

class ManageReservationsRequestListener extends EventListener {

    protected function processEvent(RequestEvent $event)
    {
        $this->logger->info('I will handle that request! My name is ' . self::class);
        $request = $event->getRequest();
        if($request->getMethod() == 'GET') {
            $request->attributes->set('warehouse', $this->buildDataWarehouse($request));
        }
        if($request->getMethod() == 'POST') {
            $categoryId = $request->request->get('category_id');
            $category = $this->em->getRepository(Category::class)->findOneBy(['id' => $categoryId]);
            $request->attributes->set('category', $category);
        }
    }

    protected function buildDataWarehouse(Request $request) {
        $warehouse = $this->kernel->getContainer()->get('app.data.warehouse.reservation');
        $params = new ReservationSearchViewModel();
        $params->setCacheDisabled(true);
        if($request->get('_route') == 'manage_reservations_particular') {
            $warehouse->setRequestType(DataWarehouse::SINGLE_ELEMENT_REQUEST_TYPE);
            $params->setId($request->attributes->get('id'));
        } else {
            $warehouse->setRequestType(DataWarehouse::LIST_REQUEST_TYPE);
        }
        $warehouse->setParams($params);
        return $warehouse;

    }

    protected function getSupportedRoutePrefix(): string
    {
        return 'manage_reservations';
    }

    protected function introduceSelf(): string
    {
        return self::class;
    }
}