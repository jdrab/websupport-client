<?php

declare(strict_types=1);

namespace Websupport\Client;

use Websupport\Client\Request;

/**
 * DNS - core object for DNS requests
 *
 * @link https://rest.websupport.sk/docs/v1.zone
 */
class DNS
{
    /**
     * userId
     * 
     * According do documentation it might be set to int
     * or string 'self' if one does not know userId for requests.
     * In constructor is set to 'self' if it's not provided
     * 
     * @var		mixed	$userid int or 'self' Default:'null';
     */
    private $userId;

    /**
     * @var		mixed	$domainName
     */
    private $domainName;

    public function __construct(Request $api, string $domainName = null, ?int $userId = null)
    {
        $this->api = $api;
        $this->userId = $userId ?? 'self';
        $this->domainName = $domainName;
        $this->response = null;
    }

    /**
     * userId.
     *
     * @return	mixed int|string
     */
    public function userId()
    {
        return $this->userId;
    }

    /**
     * domainName
     *
     * @return	string
     */
    public function domainName(): string
    {
        return $this->domainName;
    }
}
