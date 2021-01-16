<?php


namespace App\Service;


use Doctrine\ORM\Cache\CacheException;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CurrencyService
{
    private HttpClientInterface $httpClient;
    private FilesystemAdapter $cache;
    private LoggerInterface $logger;
    private ParameterBagInterface $params;
    private int $cacheValidTime;

    public function __construct(HttpClientInterface $httpClient, LoggerInterface $logger, ParameterBagInterface $params)
    {
        $this->httpClient = $httpClient;
        $this->logger = $logger;
        $this->params = $params;

        $this->cache = new FilesystemAdapter();
        $this->cacheValidTime = $params->get('currencies_cache_valid_time_hours') * 60 * 60;
    }

    public function getRates() {
        $rates = [];
        try {
            $rates = $this->cache->get($this->buildCacheKey(), function (ItemInterface $item) {
                $item->expiresAfter($this->cacheValidTime);
                return $this->fetchRates();
            });
        } catch (\Throwable | InvalidArgumentException $e) {
            $rates = ['PLN' => 1];
        }
        return $rates;
    }

    /**
     * @return array
     * @throws TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     */
    private function fetchRates() {
        $response = $this->httpClient->request('GET', $this->params->get('currency_api_url'));
        $body = json_decode( $response->getContent(), true);
        $rates = $body['rates'];
        return $rates;
    }

    private function buildCacheKey() {
        return 'currencies_' . date('Y-m-d');
    }

    public function convertToCurrencies(int $basePriceInGr, array $requestedCurrencies, array $rates): array {
        $result = [];
        foreach ($requestedCurrencies as $code) {
            if(isset($rates[$code])) {
                $converted = (floatval($basePriceInGr) * $rates[$code]) / 100;
                $result[$code] = sprintf('%.2f', $converted);
            }
        }
        return $result;
    }
}