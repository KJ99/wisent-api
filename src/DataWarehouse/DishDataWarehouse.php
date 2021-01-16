<?php


namespace App\DataWarehouse;


use ApiPlatform\Core\Api\UrlGeneratorInterface;
use App\Entity\Dish;
use App\Service\CurrencyService;
use App\ViewModel\ResponseViewModel\DishResponseViewModel;
use App\ViewModel\SearchViewModel\DishSearchViewModel;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class DishDataWarehouse extends DataWarehouse
{
    private UrlGeneratorInterface $router;
    private CurrencyService $currencyService;
    private array $currenciesRates;

    public function __construct(UrlGeneratorInterface $router, CurrencyService $currencyService, LoggerInterface $logger, ParameterBagInterface $parameterBag, EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->router = $router;
        $this->currencyService = $currencyService;
        $this->currenciesRates = ['PLN' => 1];
        parent::__construct($logger, $parameterBag, $em, $serializer);
    }

    protected function fetch()
    {
        if($this->params instanceof DishSearchViewModel && $this->params->isMultiCurrency()) {
            $this->currenciesRates = $this->currencyService->getRates();
        }
        return parent::fetch();
    }

    protected function fetchList(): array
    {
        $searchParams = $this->params != null ? $this->params->jsonSerialize() : [];
        return $this->em->getRepository(Dish::class)->findBySearchParams($searchParams);
    }

    protected function fetchParticular()
    {
        return $this->em->getRepository(Dish::class)->findOneBy(['id' => $this->params->getId()]);
    }

    protected function prepareItem($entity)
    {
        $requestedCurrencies = $this->params instanceof DishSearchViewModel ? $this->params->getRequestedCurrencies() : ['PLN'];
        $itemJson = $this->serializer->serialize($entity, 'json');
        $itemAssoc = json_decode($itemJson, true);
        $itemAssoc['base_price'] = floatval($itemAssoc['price']) / 100;
        if($this->params instanceof DishSearchViewModel && $this->params->isMultiCurrency()) {
            $itemAssoc['converted_price'] = $this->currencyService->convertToCurrencies(
                $itemAssoc['price'],
                $requestedCurrencies,
                $this->currenciesRates
            );
        }
        $itemAssoc['picture'] = $this->router->generate('resources_pictures_dish', ['id' => $entity->getId()], UrlGeneratorInterface::ABS_URL);
        return $this->serializer->deserialize(json_encode($itemAssoc), $this->getResponseModelClass(), 'json');
    }



    /**
     * @inheritDoc
     */
    protected function getCacheKey(): string
    {
        return 'dishes';
    }

    protected function getResponseModelClass(): string
    {
        return DishResponseViewModel::class;
    }

    protected function getEntityClass(): string
    {
        return Dish::class;
    }

    protected function shouldUseCache(): bool
    {
        return false;
    }
}