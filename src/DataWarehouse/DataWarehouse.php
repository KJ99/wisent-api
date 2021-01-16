<?php

namespace App\DataWarehouse;

use App\Entity\Category;
use App\Entity\User;
use App\ViewModel\ResponseViewModel\ResponseViewModel;
use App\ViewModel\SearchViewModel\SearchViewModel;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\Cache\ItemInterface;

abstract class DataWarehouse {
    const LIST_REQUEST_TYPE = 0;
    const SINGLE_ELEMENT_REQUEST_TYPE = 1;

    /**
     * @var int
     */
    protected int $requestType = self::LIST_REQUEST_TYPE;

    protected $params = null;

    protected $user = null;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ParameterBagInterface
     */
    protected $parameterBag;

    /**
     * @var integer
     */
    protected $cacheValidTime;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var FilesystemAdapter
     */
    protected $cache;

    /**
     * @var SerializerInterface 
     */
    protected SerializerInterface $serializer;

    public function __construct(
        LoggerInterface $logger,
        ParameterBagInterface $parameterBag,
        EntityManagerInterface $em,
        SerializerInterface $serializer)
    {
        $this->logger = $logger;
        $this->parameterBag = $parameterBag;
        $this->em = $em;
        $this->cacheValidTime = $parameterBag->get('customer_get_cache_valid_time_min') * 60;
        $this->cache = new FilesystemAdapter();
        $this->serializer = $serializer;
    }

    /**
     * @param string $prefix
     * @return string
     */
    protected function buildCacheKey(): string {
        $prefix = $this->requestType == self::LIST_REQUEST_TYPE ? 'list' : 'particular';
        $parametersHash = $this->getParametersHash();
        $baseCacheKey = $this->getCacheKey();
        $parts = [$prefix, $baseCacheKey, $parametersHash];
        return implode('.', $parts);
    }

    protected function getParametersHash(): string {
        $json = $this->params != null ? json_encode($this->params) : '{}';
        return md5($json);
    }

    public function get() {
        $result = [];
        if($this->shouldUseCache()) {
            $result = $this->loadFromCache();
        } else {
            $this->logger->info($this->introduceMe() . ' data warehouse fetches from the database');
            $result = $this->prepare($this->fetch());
        }
        return $result;
    }

    protected function loadFromCache() {
        $cacheKey = $this->buildCacheKey();
        $this->logger->info($this->introduceMe() . ' data warehouse is searching in the cache for params ' . json_encode($this->params));
        $result = [];
        try {
            $result = $this->cache->get($cacheKey, function (ItemInterface $item) {
                $this->logger->info($this->introduceMe() . ' data warehouse does not find suitable data in cache');
                $item->expiresAfter($this->cacheValidTime);
                $this->logger->info($this->introduceMe() . ' data warehouse is caching for params ' . json_encode($this->params));
                return $this->prepare($this->fetch());
            });
        } catch (InvalidArgumentException $e) {
            $this->logger->warning('Exception was caught when reading the cache. Exception: ' . $e->getMessage() . ' Details: ' . json_encode($e));
        }
        return  $result;
    }

    protected function fetch() {
        return $this->requestType == self::LIST_REQUEST_TYPE ? $this->fetchList() : $this->fetchParticular();
    }

    protected function fetchList(): array
    {
        return $this->em->getRepository($this->getEntityClass())->findBy($this->getParamsJson());
    }

    protected function fetchParticular()
    {
        return $this->em->getRepository($this->getEntityClass())->findOneBy($this->getParamsJson());
    }
    
    protected function prepare($data) {
        return $this->requestType == self::LIST_REQUEST_TYPE ? $this->prepareList($data) : $this->prepareItem($data);
    }

    protected function prepareList($data): array {
        $prepared = [];
        foreach ($data as $item) {
            $prepared[] = $this->prepareItem($item);
        }
        return $prepared;
    }

    protected function prepareItem($entity) {
        if($entity == null) {
            throw new NotFoundHttpException($this->getNotFoundMessage());
        }
        $json = $this->serializer->serialize($entity, 'json');
        return $this->serializer->deserialize($json, $this->getResponseModelClass(), 'json');
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @param SearchViewModel $params
     */
    public function setParams(SearchViewModel $params): void
    {
        $this->params = $params;
    }

    protected function shouldUseCache(): bool {
        return ($this->params != null && $this->params->isCacheDisabled()) || $this->user == null || !$this->user->isAdmin();
    }

    
    /**
     * @param int $requestType
     */
    public function setRequestType(int $requestType): void
    {
        $this->requestType = $requestType;
    }

    /**
     * @return int
     */
    public function getRequestType(): int
    {
        return $this->requestType;
    }

    /**
     * @return string
     */
    protected abstract function getCacheKey(): string;

    protected function getParamsJson() {
        return $this->params != null ? $this->params->jsonSerialize() : [];
    }
    
    protected abstract function getResponseModelClass(): string;
    
    protected abstract function getEntityClass(): string;

    protected function introduceMe(): string {
        return self::class;
    }

    protected function getNotFoundMessage(): string {
        return 'Data not found';
    }
}