<?php


namespace App\EventListener;


use App\DataWarehouse\DataWarehouse;
use App\Entity\Category;
use App\Entity\Picture;
use App\Entity\Subcategory;
use App\ViewModel\SearchViewModel\DishSearchViewModel;
use App\ViewModel\SearchViewModel\SubcategorySearchViewModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class ManageDishesRequestListener extends EventListener
{

    protected function processEvent(RequestEvent $event)
    {
        $this->logger->info('I will handle that request! My name is ' . self::class);
        $request = $event->getRequest();
        if($request->getMethod() == 'GET') {
            $request->attributes->set('warehouse', $this->buildDataWarehouse($request));
        }
        if($request->getMethod() == 'POST') {
            $subcategoryId = $request->request->get('subcategory_id');
            $category = $this->em->getRepository(Subcategory::class)->findOneBy(['id' => $subcategoryId]);
            $request->attributes->set('subcategory', $category);
            $pictureId = $request->request->get('picture_id');
            $picture = $this->em->getRepository(Picture::class)->findOneBy(['id' => $pictureId]);
            $request->attributes->set('picture', $picture);
        } else if($request->getMethod() == 'PATCH') {
            $pictureId = $request->request->get('picture_id');
            $picture = $this->em->getRepository(Picture::class)->findOneBy(['id' => $pictureId]);
            $request->attributes->set('picture', $picture);
        }
    }


    protected function buildDataWarehouse(Request $request) {
        $warehouse = $this->kernel->getContainer()->get('app.data.warehouse.dish');
        $params = new DishSearchViewModel();
        $params->setCacheDisabled(true);
        if($request->get('_route') == 'manage_dishes_particular') {
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
        return 'manage_dishes';
    }

    protected function introduceSelf(): string
    {
        return self::class;
    }
}