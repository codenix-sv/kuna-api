<?php

declare(strict_types=1);

namespace Codenixsv\KunaApi;

use Codenixsv\KunaApi\Api\PrivateApi;
use Codenixsv\KunaApi\Api\PublicApi;

/**
 * Class KunaClient
 * @package Codenixsv\KunaApi+
 */
class KunaClient
{
    private const BASE_URI = 'https://kuna.io/api/v2';

    /** @var string  */
    private $publicKey;
    /** @var string  */
    private $secretKey;

    /**
     * KunaClient constructor.
     * @param string $publicKey
     * @param string $secretKey
     */

    public function __construct(string $publicKey = '', string $secretKey = '')
    {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
    }

    /**
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return self::BASE_URI;
    }

    /**
     * @return PrivateApi
     */
    public function privateApi(): PrivateApi
    {
        return new PrivateApi($this);
    }

    /**
     * @return PublicApi
     */
    public function publicApi(): PublicApi
    {
        return new PublicApi($this);
    }
}
