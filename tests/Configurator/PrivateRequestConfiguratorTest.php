<?php

declare(strict_types=1);

namespace Codenixsv\KunaApi\Tests\Configurator;

use Codenixsv\KunaApi\Configurator\PrivateRequestConfigurator;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class PrivateRequestConfiguratorTest extends TestCase
{
    public function testConfigure()
    {
        $uri = $this->createMock('Psr\Http\Message\UriInterface');
        $uri->method('getQuery')->willReturn('market=btcuah');
        $uri->method('getPath')->willReturn('/api/v2/trades/my');
        $uri->method('withQuery')->willReturn($this->createMock('Psr\Http\Message\UriInterface'));

        $uri->expects($this->once())->method('getQuery');
        $uri->expects($this->once())->method('getPath');
        $uri->expects($this->once())->method('withQuery');

        $request = $this->createMock('Psr\Http\Message\RequestInterface');
        $request->method('getUri')->willReturn($uri);
        $request->method('getMethod')->willReturn('GET');
        $request->method('withUri')->willReturn($this->createMock('Psr\Http\Message\RequestInterface'));

        $request->expects($this->once())->method('getUri');
        $request->expects($this->once())->method('getMethod');
        $request->expects($this->once())->method('withUri');

        $configurator = new PrivateRequestConfigurator('dV6vEJe1CO', 'AYifzxC3Xo');

        $result = $configurator->configure($request);

        $this->assertInstanceOf(RequestInterface::class, $result);
    }

    public function testGetSignedData()
    {
        $configurator = new PrivateRequestConfigurator('dV6vEJe1CO', 'AYifzxC3Xo');

        $result = $configurator->getSignedData(['market' => 'btcuah'], '/api/v2/trades/my', 'GET', 1465850766246);

        $this->assertEquals([
            'access_key' => 'dV6vEJe1CO',
            'market' => 'btcuah',
            'tonce' => '1465850766246',
            'signature' => '33a694498a2a70cb4ca9a7e28224321e20b41f10217604e9de80ff4ee8cf310e'
        ], $result);
    }
}
