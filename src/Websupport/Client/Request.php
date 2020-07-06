<?php

declare(strict_types=1);

namespace Websupport\Client;

use Websupport\Client\Interfaces\Request as RequestInterface;
use Websupport\Client\Exception as ClientException;

class Request implements RequestInterface
{
    /**
     * response
     *
     * @var mixed
     */
    public $response;

    /**
     * entryPoint
     *
     * @var string
     */
    private $entryPoint;

    /**
     * apiKey
     *
     * @var string
     */
    private $apiKey;
    /**
     * secret
     *
     * @var string
     */
    private $secret;

    /**
     * __construct
     *
     * @param  string $entryPoint
     * @param  string $key
     * @param  string $secret
     * @return void
     */
    public function __construct(string $entryPoint, string $key, string $secret)
    {
        $this->entryPoint = $entryPoint;
        $this->apiKey = $key;
        $this->secret = $secret;
    }

    /**
     * init
     *
     * @throws ClientException
     *
     * @param string $path Endpoint path
     * @param int $time unixtimestamp
     * @return void
     */
    public function init(string $path, int $time)
    {
        $ch = curl_init();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, sprintf('%s:%s', $this->entryPoint, $path));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ':' . $this->signature);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Date: ' . gmdate('Y-m-d\TH:i:s\Z', $time),
        ]);

        if (!is_resource($ch)) {
            throw new ClientException('Invalid cURL resource');
        }
        return $ch;
    }

    /**
     * sign
     *
     * @param  string $method Supported HTTP method
     * @param  string $path Endpoint path
     * @param  int    $time unixtimestamp
     * @return object
     */
    public function sign(string $method, string $path, int $time): object
    {
        $canonicalRequest = sprintf('%s %s %s', $method, $path, $time);
        $this->signature        = hash_hmac('sha1', $canonicalRequest, $this->secret);
        return $this;
    }

    /**
     * response
     *
     * @return string
     */
    public function response(): string
    {
        return $this->response;
    }

    /**
     * exec
     *
     * @param  mixed $curl_resource
     * @return object
     */
    private function exec($curl_resource): object
    {
        $this->response = curl_exec($curl_resource);
        return $this;
    }

    /**
     * close
     *
     * @param  mixed $curlResource
     * @return void
     */
    private function close($curlResource): void
    {
        curl_close($curlResource);
    }

    /**
     * request
     *
     * @param  mixed $method
     * @param  mixed $path
     * @return object
     */
    public function request($method, $path): object
    {
        $time = time();
        $this->sign($method, $path, $time);
        $res = $this->init($path, $time);
        $this->exec($res);
        $this->close($res);
        return $this;
    }
}
