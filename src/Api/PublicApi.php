<?php

declare(strict_types=1);

namespace Codenixsv\KunaApi\Api;

use Codenixsv\KunaApi\Exception\TransformResponseException;

/**
 * Class PublicApi
 * @package Codenixsv\KunaApi\Api
 */
class PublicApi extends Api
{
    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        $response = $this->getBaseClient()->get('/timestamp');

        return (string) $response->getBody();
    }

    /**
     * @param string $symbols
     * @return array
     * @throws TransformResponseException
     */
    public function getTickers(string $symbols): array
    {
        $response = $this->getBaseClient()->get('/tickers/' . strtolower($symbols));

        return $this->getTransformer()->transform($response);
    }

    /**
     * @param string $market
     * @return array
     * @throws TransformResponseException
     */
    public function getDepth(string $market): array
    {
        $query = http_build_query(['market' => strtolower($market)]);
        echo $query;
            $response = $this->getBaseClient()->get('/depth?' . $query);

        return $this->getTransformer()->transform($response);
    }

    /**
     * @param string $market
     * @return array
     * @throws TransformResponseException
     */
    public function getTrades(string $market): array
    {
        $query = http_build_query(['market' => strtolower($market)]);
        echo $query;
        $response = $this->getBaseClient()->get('/trades?' . $query);

        return $this->getTransformer()->transform($response);
    }
}
