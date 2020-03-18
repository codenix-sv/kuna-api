<?php

declare(strict_types=1);

namespace Codenixsv\KunaApi\Tests\Api;

use Codenixsv\ApiClient\BaseClientInterface;
use Codenixsv\KunaApi\Api\Api;
use Codenixsv\KunaApi\KunaClient;
use Codenixsv\KunaApi\Message\ResponseTransformer;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    public function testGetTransformer()
    {
        $api = new Api(new KunaClient());

        $this->assertInstanceOf(ResponseTransformer::class, $api->getTransformer());
    }

    public function testGetBaseClient()
    {
        $api = new Api(new KunaClient());

        $this->assertInstanceOf(BaseClientInterface::class, $api->getBaseClient());
    }
}
