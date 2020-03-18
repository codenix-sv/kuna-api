<?php

declare(strict_types=1);

namespace Codenixsv\KunaApi\Exception;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Class TransformResponseException
 * @package Codenixsv\KunaApi\Exception
 */
class TransformResponseException extends Exception
{
    private $response;

    /**
     * TransformResponseException constructor.
     * @param ResponseInterface $response
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(ResponseInterface $response, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->response = $response;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
