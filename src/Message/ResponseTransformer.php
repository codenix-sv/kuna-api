<?php

declare(strict_types=1);

namespace Codenixsv\KunaApi\Message;

use Codenixsv\KunaApi\Exception\TransformResponseException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ResponseTransformer
 * @package Codenixsv\KunaApi\Message
 */
class ResponseTransformer
{
    /**
     * @param ResponseInterface $response
     * @return array
     * @throws TransformResponseException
     */
    public function transform(ResponseInterface $response): array
    {
        $body = (string) $response->getBody();
        $content = json_decode($body, true);
        if (JSON_ERROR_NONE === json_last_error()) {
            return $content;
        }

        throw new TransformResponseException($response, 'Error transforming response to array');
    }
}
