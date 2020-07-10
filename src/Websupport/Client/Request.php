<?php

declare(strict_types=1);

namespace Websupport\Client;

// use SplObserver;
// use SplSubject;

use Websupport\Client\Interfaces\Request as RequestInterface;
use Websupport\Client\Exception as ClientException;

class Request implements RequestInterface //SplSubject,
{
    /**
     * 
     * @var string
     */
    private string $response;

    /**
     * Hashing algorithm used by hash_hmac
     * 
     * @var	string	$hmacAlgo
     */
    private string $hmacAlgo;

    /**
     * Reseponse code from request
     * 
     * @var	string	$statusCode
     */
    private int $statusCode;

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
        $this->hmacAlgo = 'sha1';
    }

    /**
     * init
     *
     * @throws ClientException
     *
     * @param string $path Endpoint path
     * @param int $time unixtimestamp
     * 
     * @return mixed cURL resource
     */
    public function init(string $path, int $time)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, sprintf('%s:%s', $this->entryPoint, $path));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ':' . $this->signature);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Date: ' . gmdate('Y-m-d\TH:i:s\Z', $time),
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        if (!is_resource($ch)) {
            throw new ClientException('Invalid cURL resource');
        }
        return $ch;
    }


    /**
     * sign
     * 
     * Create request hmac signature request - method,path and time
     * 
     * WARNING: websupport api does not use body data while generating hmac signature
     *
     * @param  string $method Supported HTTP method
     * @param  string $path Endpoint path
     * @param  int    $time unixtimestamp
     * @param  array  $data are not required - see WARNING above
     * @return object
     */
    public function sign(string $method, string $path, int $time, array $data = []): object
    {
        $canonicalRequest = sprintf('%s %s %s', $method, $path, $time);
        $this->signature  = hash_hmac($this->hmacAlgo, $canonicalRequest, $this->secret);
        return $this;
    }

    /**
     * response
     *
     * @return string response body
     */
    public function response(): string
    {
        $str = $this->response;

        unset($this->response);

        return $str;
    }

    public function jsonResponse(): string
    {
        return json_encode(json_decode($this->response()), JSON_PRETTY_PRINT);
    }


    /**
     * statusCode
     *
     * @return int statusCode HTTP Status code from request
     */
    public function statusCode(): int
    {
        return $this->statusCode;
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
     * @param  string $method
     * @param  string $path
     * @param  array  $data
     * 
     * @return object
     */
    public function request(string $method, string $path, array $data = []): object
    {
        $time = time();
        $this->sign($method, $path, $time); //, $data);

        $res = $this->init($path, $time);

        curl_setopt($res, CURLOPT_CUSTOMREQUEST, $method);

        if ($data) {
            curl_setopt($res, CURLOPT_POST, 1);
            curl_setopt($res, CURLOPT_POSTFIELDS, json_encode($data));
        }


        $this->exec($res);

        $info = curl_getinfo($res);
        $this->statusCode = $info['http_code'];
        $this->debugInfo = $info;
        $this->debugInfo['data'] = $data;

        $this->close($res);
        return $this;
    }

    /**
     * Debug info from curl request
     *
     * most helpful are 'request_header' and 'data';
     * 
     * @return array 
     */
    public function debugInfo(): array
    {
        return $this->debugInfo;
    }

    // public function attach(SplObserver $observer)
    // {
    // }
    // public function detach(SplObserver $observer)
    // {
    // }
    // public function notify()
    // {
    // }
}
