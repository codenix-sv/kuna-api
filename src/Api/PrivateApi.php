<?php

declare(strict_types=1);

namespace Codenixsv\KunaApi\Api;

use Codenixsv\ApiClient\BaseClient;
use Codenixsv\ApiClient\BaseClientInterface;
use Codenixsv\KunaApi\Configurator\PrivateRequestConfigurator;
use Codenixsv\KunaApi\KunaClient;
use Codenixsv\KunaApi\Exception\TransformResponseException;

/**
 * Class PrivateApi
 * @package Codenixsv\KunaApi\Api
 */
class PrivateApi extends Api
{
    /**
     * PrivateApi constructor.
     * @param KunaClient $client
     * @param BaseClientInterface|null $baseClient
     */
    public function __construct(KunaClient $client, ?BaseClientInterface $baseClient = null)
    {
        $baseClient = $baseClient ?: new BaseClient();
        $configurator = new PrivateRequestConfigurator($client->getPublicKey(), $client->getSecretKey());
        $baseClient->addRequestConfigurator($configurator);
        parent::__construct($client, $baseClient);
    }

    /**
     * @return array
     * @throws TransformResponseException
     */
    public function getMe()
    {
        $response = $this->getBaseClient()->get('/members/me');

        return $this->getTransformer()->transform($response);
    }

    /**
     * @param string $side
     * @param float $volume
     * @param string $market
     * @param float $price
     * @return array
     * @throws TransformResponseException
     */
    public function createOrder(string $side, float $volume, string $market, float $price)
    {
        $body = http_build_query([
            'side' => $side,
            'volume' => $volume,
            'market' => $market,
            'price' => $price
        ]);

        $response = $this->getBaseClient()->post('/orders', $body);

        return $this->getTransformer()->transform($response);
    }


    /**
     * @param int $id
     * @return array
     * @throws TransformResponseException
     */
    public function deleteOrder(int $id)
    {
        $body = http_build_query(['id' => $id]);
        $response = $this->getBaseClient()->post('/order/delete', $body);

        return $this->getTransformer()->transform($response);
    }

    /**
     * @param string $market
     * @return array
     * @throws TransformResponseException
     */
    public function getOrders(string $market)
    {
        $query = http_build_query(['market' => strtolower($market)]);
        $response = $this->getBaseClient()->get('/orders?' . $query);

        return $this->getTransformer()->transform($response);
    }

    /**
     * @param string $market
     * @return array
     * @throws TransformResponseException
     */
    public function getMyTrades(string $market)
    {
        $query = http_build_query(['market' => strtolower($market)]);
        $response = $this->getBaseClient()->get('/trades/my?' . $query);

        return $this->getTransformer()->transform($response);
    }
}
