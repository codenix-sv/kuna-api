<?php

declare(strict_types=1);

namespace Codenixsv\KunaApi\Tests\Exception;

use Codenixsv\KunaApi\Exception\TransformResponseException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class TransformResponseExceptionTest extends TestCase
{
    public function testGetResponse()
    {
        $response = $this->createMock('Psr\Http\Message\ResponseInterface');
        $exception = new TransformResponseException($response);

        $this->assertInstanceOf(ResponseInterface::class, $exception->getResponse());
    }
}
