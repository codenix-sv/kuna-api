<?php

declare(strict_types=1);

namespace Codenixsv\KunaApi\Tests;

use Codenixsv\KunaApi\Api\PrivateApi;
use Codenixsv\KunaApi\Api\PublicApi;
use Codenixsv\KunaApi\KunaClient;
use PHPUnit\Framework\TestCase;

class KunaClientTest extends TestCase
{
    public function testPublicApi()
    {
        $client = new KunaClient();

        $this->assertInstanceOf(PublicApi::class, $client->publicApi());
    }

    public function testPrivateApi()
    {
        $client = new KunaClient();

        $this->assertInstanceOf(PrivateApi::class, $client->privateApi());
    }
}
