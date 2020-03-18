<?php

declare(strict_types=1);

namespace Codenixsv\KunaApi\Tests\Api;

use Codenixsv\ApiClient\BaseClient;
use Codenixsv\KunaApi\Api\PublicApi;
use Codenixsv\KunaApi\KunaClient;
use Http\Mock\Client as HttpMockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PublicApiTest extends TestCase
{
    public function testGetTimestamp()
    {
        $api = $this->createApi($this->createMock('Psr\Http\Message\ResponseInterface'));
        $api->getTimestamp();

        /** @var RequestInterface $request */
        $request = $api->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals('https://kuna.io/api/v2/timestamp', $request->getUri()->__toString());
    }

    public function testGetTickers()
    {
        $api = $this->createApi($this->mockSuccessfulResponse());
        $api->getTickers('btcuah');

        /** @var RequestInterface $request */
        $request = $api->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals('https://kuna.io/api/v2/tickers/btcuah', $request->getUri()->__toString());
    }

    public function testGetDepth()
    {
        $api = $this->createApi($this->mockSuccessfulResponse());
        $api->getDepth('btcuah');

        /** @var RequestInterface $request */
        $request = $api->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals('https://kuna.io/api/v2/depth?market=btcuah', $request->getUri()->__toString());
    }

    public function testGetTrades()
    {
        $api = $this->createApi($this->mockSuccessfulResponse());
        $api->getTrades('btcuah');

        /** @var RequestInterface $request */
        $request = $api->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals('https://kuna.io/api/v2/trades?market=btcuah', $request->getUri()->__toString());
    }

    /**
     * @param ResponseInterface $response
     * @return PublicApi
     */
    private function createApi(ResponseInterface $response): PublicApi
    {
        $httpClientMock = new HttpMockClient();
        $httpClientMock->addResponse($response);
        $baseClient = new BaseClient($httpClientMock);

        return new PublicApi(new KunaClient(), $baseClient);
    }

    /**
     * @return ResponseInterface
     */
    private function mockSuccessfulResponse(): ResponseInterface
    {
        $response = $this->createMock('Psr\Http\Message\ResponseInterface');
        $response->method('getBody')->willReturn(json_encode([]));
        $response->method('getHeaderLine')->willReturn('application/json');
        return $response;
    }
}
