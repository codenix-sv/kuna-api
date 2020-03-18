<?php

declare(strict_types=1);

namespace Codenixsv\KunaApi\Tests\Message;

use Codenixsv\KunaApi\Message\ResponseTransformer;
use Codenixsv\KunaApi\Exception\TransformResponseException;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ResponseTransformerTest extends TestCase
{
    public function testTransform()
    {
        $transformer = new ResponseTransformer();
        $data = ['foo' => 'bar'];
        $response = new Response(200, ['Content-Type' => 'application/json'], json_encode($data));

        $this->assertEquals($data, $transformer->transform($response));
    }

    public function testTransformWithEmptyBody()
    {
        $transformer = new ResponseTransformer();
        $data = [];
        $response = new Response(200, ['Content-Type' => 'application/json'], json_encode($data));

        $this->assertEquals($data, $transformer->transform($response));
    }

    public function testTransformThrowTransformResponseException()
    {
        $transformer = new ResponseTransformer();
        $response = new Response(200, ['Content-Type' => 'application/pdf'], '');

        $this->expectException(TransformResponseException::class);

        $transformer->transform($response);
    }
}
