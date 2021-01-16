<?php


namespace App\EventListener;


use App\DataWarehouse\CategoryDataWarehouse;
use App\DataWarehouse\DataWarehouse;
use App\ViewModel\ResponseViewModel\ResponseViewModel;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelInterface;

class MenuRequestListener
{
    private LoggerInterface $logger;
    private KernelInterface $kernel;

    public function __construct(LoggerInterface $logger, KernelInterface $kernel)
    {
        $this->logger = $logger;
        $this->kernel = $kernel;
    }

    public function onKernelRequest(RequestEvent $event) {
        $request = $event->getRequest();
        if(!preg_match('/^menu_.*/', $request->get('_route'))) {
            $this->logger->info('MenuRequestListener does not support this route. Skipped');
            return;
        }
        if(strtolower($request->getMethod()) == 'get') {
            $dataWarehouse = $this->createDataWarehouse($request);
            $request->attributes->set('dataWarehouse', $dataWarehouse);
        }

    }

    private function createDataWarehouse(Request $request) {
        $dataWarehouse = null;
        switch ($request->get('_route')) {
            case 'menu_categories_list':
                $dataWarehouse = $this->kernel->getContainer()->get('app.data.warehouse.category');
                $dataWarehouse->setRequestType(DataWarehouse::LIST_REQUEST_TYPE);
                break;
        }
        return $dataWarehouse;
    }


}