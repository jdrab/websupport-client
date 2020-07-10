<?php

declare(strict_types=1);

namespace Websupport\Client\DNS;

use Websupport\Client\Request;

/**
 * Zones
 *
 * @link http://rest.websupport.sk/docs/v1.zone#zone
 */
class Zones
{
    /**
     * @var		mixed	$userid int or 'self'
     */
    private $userId;
    private $domainName;

    public function __construct(Request $api, ?string $domainName = null, ?int $userId = null)
    {
        $this->api = $api;
        $this->userId = $userId ?? 'self';
        $this->path = join('/', ['/v1/user', $this->userId, 'zone']);
        $this->domainName = $domainName;
        $this->response = null;
    }

    /**
     * listAll
     * 
     * List all domain zones     
     *
     * @access	public
     * @param	string	$method	Default: 'GET'
     * @return	object
     */
    public function listAll(string $method = 'GET'): object
    {
        $path = $path ?? $this->path;

        return $this->api->request($method, $path);
    }

    /**
     * details.
     * 
     * @link http://rest.websupport.sk/docs/v1.zone#zone
     *
     * @param	string	$domainName	Default: null
     * @param	string	$method    	Default: 'GET'
     * @return	object
     */
    public function details(string $domainName = null, string $method = 'GET'): object
    {
        $domainName = $doaminName ?? $this->domainName;
        $path = join('/', [$this->path, $domainName]);

        return $this->api->request($method, $path);
    }
}
    
/*
DNS zone management resources:

 [x] List of all zones
 [x] Get a zone detail
 
*/