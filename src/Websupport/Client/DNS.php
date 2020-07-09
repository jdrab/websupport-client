<?php

declare(strict_types=1);

namespace Websupport\Client;

use Websupport\Client\Request;
use Websupport\Client\Exception as ClientException;

/**
 * Users
 *
 * @link https://rest.websupport.sk/docs/v1.user
 */
class DNS
{
    /**
     * @var		mixed	$userid int or 'self'
     */
    private $userId;
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
     * domainName.
     *
     * @return	string
     */
    public function domainName(): string
    {
        return $this->domainName;
    }
}
