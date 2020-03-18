<?php

declare(strict_types=1);

namespace Codenixsv\KunaApi\Api;

use Codenixsv\ApiClient\BaseClient;
use Codenixsv\ApiClient\BaseClientInterface;
use Codenixsv\KunaApi\KunaClient;
use Codenixsv\KunaApi\Message\ResponseTransformer;

/**
 * Class PrivateApi
 * @package Codenixsv\KunaApi\Api
 */
class Api
{
    /** @var ResponseTransformer */
    private $transformer;
    /** @var BaseClientInterface */
    private $baseClient;
    /** @var KunaClient  */
    private $client;

    /**
     * Api constructor.
     * @param KunaClient $client
     * @param BaseClientInterface|null $baseClient
     */
    public function __construct(KunaClient $client, ?BaseClientInterface $baseClient = null)
    {
        $this->client = $client;
        $this->baseClient = $baseClient ?: new BaseClient();
        $this->baseClient->setBaseUri($this->client->getBaseUri());
        $this->transformer = new ResponseTransformer();
    }

    /**
     * @return ResponseTransformer
     */
    public function getTransformer(): ResponseTransformer
    {
        return $this->transformer;
    }

    /**
     * @return BaseClientInterface
     */
    public function getBaseClient(): BaseClientInterface
    {
        return $this->baseClient;
    }
}
