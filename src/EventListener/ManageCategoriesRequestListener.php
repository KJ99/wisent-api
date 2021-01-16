<?php


namespace App\EventListener;


use App\DataWarehouse\CategoryDataWarehouse;
use App\DataWarehouse\DataWarehouse;
use App\ViewModel\SearchViewModel\CategorySearchViewModel;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelInterface;

class ManageCategoriesRequestListener extends EventListener {

    protected function processEvent(RequestEvent $event)
    {
        $this->logger->info('I will handle that request! My name is ' . self::class);
        $request = $event->getRequest();
        if($request->getMethod() == 'GET') {
            $request->attributes->set('warehouse', $this->buildDataWarehouse($request));
        }
    }

    protected function buildDataWarehouse(Request $request) {
        $warehouse = $this->kernel->getContainer()->get('app.data.warehouse.category');
        $params = new CategorySearchViewModel();
        $params->setCacheDisabled(true);
        if($request->get('_route') == 'manage_categories_particular') {
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
        return 'manage_categories';
    }

    protected function introduceSelf(): string
    {
        return self::class;
    }
}