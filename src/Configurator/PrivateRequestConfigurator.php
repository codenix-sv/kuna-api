<?php

declare(strict_types=1);

namespace Codenixsv\KunaApi\Configurator;

use Codenixsv\ApiClient\configurator\RequestConfiguratorInterface;
use Psr\Http\Message\RequestInterface;

use function GuzzleHttp\Psr7\stream_for;

/**
 * Interface RequestConfiguratorInterface
 * @package Codenixsv\ApiClient
 */
class PrivateRequestConfigurator implements RequestConfiguratorInterface
{
    /** @var string  */
    private $publicKey;
    /** @var string  */
    private $secretKey;

    /**
     * PrivateRequestConfigurator constructor.
     * @param string $publicKey
     * @param string $secretKey
     */
    public function __construct(string $publicKey, string $secretKey)
    {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
    }

    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function configure(RequestInterface $request): RequestInterface
    {
        $method = $request->getMethod();

        if ($method === 'GET') {
            $request = $this->configureGetRequest($request);
        }

        if ($method === 'POST') {
            $request = $this->configurePostRequest($request);
        }

        return $request;
    }

    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    private function configurePostRequest(RequestInterface $request): RequestInterface
    {
        parse_str((string) $request->getBody(), $params);
        $signedData = $this->getSignedData(
            $params,
            $request->getUri()->getPath(),
            'POST',
            $this->generateTonce()
        );

        $request = $request->withBody(stream_for(http_build_query($signedData)));

        return $request->withHeader('Content-Type', 'application/x-www-form-urlencoded');
    }

    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    private function configureGetRequest(RequestInterface $request): RequestInterface
    {
        $uri = $request->getUri();
        parse_str($uri->getQuery(), $params);
        $signedData = $this->getSignedData(
            $params,
            $uri->getPath(),
            'GET',
            $this->generateTonce()
        );
        $signedUri = $uri->withQuery(http_build_query($signedData));

        return $request->withUri($signedUri);
    }

    /**
     * @param array $data
     * @param string $path
     * @param string $method
     * @param int $tonce
     * @return array
     */
    public function getSignedData(array $data, string $path, string $method, int $tonce): array
    {
        $params = array_merge($data, ['tonce' => $tonce, 'access_key' => $this->publicKey]);
        ksort($params, SORT_STRING);
        $signature = $this->generateSignature($method, $path, $params, $this->secretKey);
        $params['signature'] = $signature;

        return $params;
    }

    /**
     * @param string $method
     * @param string $path
     * @param array $query
     * @param string $secretKey
     * @return string
     */
    private function generateSignature(string $method, string $path, array $query, string $secretKey): string
    {
        $data = implode('|', [$method, $path, http_build_query($query)]);

        return hash_hmac('SHA256', $data, $secretKey);
    }

    /**
     * @return int
     */
    private function generateTonce(): int
    {
        return (int)(microtime(true) * 1000);
    }
}
