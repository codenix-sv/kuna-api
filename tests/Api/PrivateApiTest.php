<?php

declare(strict_types=1);

namespace Codenixsv\KunaApi\Tests\Api;

use Codenixsv\ApiClient\BaseClient;
use Codenixsv\KunaApi\Api\PrivateApi;
use Codenixsv\KunaApi\KunaClient;
use Http\Mock\Client as HttpMockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use function GuzzleHttp\Psr7\parse_query;

class PrivateApiTest extends TestCase
{
    public function testGetMe()
    {
        $api = $this->createApi($this->mockSuccessfulResponse());
        $api->getMe();

        /** @var RequestInterface $request */
        $request = $api->getBaseClient()->getHttpClient()->getLastRequest();
        $uri = $request->getUri();
        $path = $uri->getPath();
        $host = $uri->getHost();
        $scheme = $uri->getScheme();
        $params = parse_query($uri->getQuery());

        $this->assertEquals('/api/v2/members/me', $path);
        $this->assertEquals('kuna.io', $host);
        $this->assertEquals('https', $scheme);
        $this->assertArrayHasKey('access_key', $params);
        $this->assertArrayHasKey('tonce', $params);
        $this->assertArrayHasKey('signature', $params);
    }

    public function testCreateOrder()
    {
        $api = $this->createApi($this->mockSuccessfulResponse());

        $side = 'sell';
        $volume = 1.00;
        $market = 'btcuah';
        $price = 10000.00;

        $api->createOrder($side, $volume, $market, $price);

        /** @var RequestInterface $request */
        $request = $api->getBaseClient()->getHttpClient()->getLastRequest();
        $uri = $request->getUri();
        $path = $uri->getPath();
        $host = $uri->getHost();
        $scheme = $uri->getScheme();
        $params = parse_query((string)$request->getBody());

        $this->assertEquals('/api/v2/orders', $path);
        $this->assertEquals('kuna.io', $host);
        $this->assertEquals('https', $scheme);
        $this->assertArrayHasKey('access_key', $params);
        $this->assertArrayHasKey('tonce', $params);
        $this->assertArrayHasKey('signature', $params);
        $this->assertArrayHasKey('side', $params);
        $this->assertArrayHasKey('volume', $params);
        $this->assertArrayHasKey('market', $params);
        $this->assertArrayHasKey('price', $params);
    }

    public function testDeleteOrder()
    {
        $api = $this->createApi($this->mockSuccessfulResponse());

        $id = 12345;

        $api->deleteOrder($id);

        /** @var RequestInterface $request */
        $request = $api->getBaseClient()->getHttpClient()->getLastRequest();
        $uri = $request->getUri();
        $path = $uri->getPath();
        $host = $uri->getHost();
        $scheme = $uri->getScheme();
        $params = parse_query((string)$request->getBody());

        $this->assertEquals('/api/v2/order/delete', $path);
        $this->assertEquals('kuna.io', $host);
        $this->assertEquals('https', $scheme);
        $this->assertArrayHasKey('access_key', $params);
        $this->assertArrayHasKey('tonce', $params);
        $this->assertArrayHasKey('signature', $params);
        $this->assertArrayHasKey('id', $params);
    }

    public function testGetOrders()
    {
        $api = $this->createApi($this->mockSuccessfulResponse());
        $api->getOrders('btcuah');

        /** @var RequestInterface $request */
        $request = $api->getBaseClient()->getHttpClient()->getLastRequest();
        $uri = $request->getUri();
        $path = $uri->getPath();
        $host = $uri->getHost();
        $scheme = $uri->getScheme();
        $params = parse_query($uri->getQuery());

        $this->assertEquals('/api/v2/orders', $path);
        $this->assertEquals('kuna.io', $host);
        $this->assertEquals('https', $scheme);
        $this->assertArrayHasKey('market', $params);
        $this->assertArrayHasKey('access_key', $params);
        $this->assertArrayHasKey('tonce', $params);
        $this->assertArrayHasKey('signature', $params);
    }

    public function testGetMyTrades()
    {
        $api = $this->createApi($this->mockSuccessfulResponse());
        $api->getMyTrades('btcuah');

        /** @var RequestInterface $request */
        $request = $api->getBaseClient()->getHttpClient()->getLastRequest();
        $uri = $request->getUri();
        $path = $uri->getPath();
        $host = $uri->getHost();
        $scheme = $uri->getScheme();
        $params = parse_query($uri->getQuery());

        $this->assertEquals('/api/v2/trades/my', $path);
        $this->assertEquals('kuna.io', $host);
        $this->assertEquals('https', $scheme);
        $this->assertArrayHasKey('market', $params);
        $this->assertArrayHasKey('access_key', $params);
        $this->assertArrayHasKey('tonce', $params);
        $this->assertArrayHasKey('signature', $params);
    }

    /**
     * @param ResponseInterface $response
     * @return PrivateApi
     */
    private function createApi(ResponseInterface $response): PrivateApi
    {
        $httpClientMock = new HttpMockClient();
        $httpClientMock->addResponse($response);
        $baseClient = new BaseClient($httpClientMock);

        return new PrivateApi(new KunaClient(), $baseClient);
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
