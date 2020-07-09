<?php

declare(strict_types=1);

namespace Websupport\Client\DNS;

use Websupport\Client\Request;

/**
 * Users
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
     * Note from docs: if you don't know user ID of currently logged user,
     * you can use string "self", i.e.: path will be "/v1/user/self/zone"
     * @todo optional parameters 'page' and 'pagesize' are not implemented
     *
     * @access	public
     * @param	string	$method	Default: 'GET'
     * @return	mixed
     */
    public function listZones(string $method = 'GET'): object
    {
        $path = $path ?? $this->path;

        return $this->api->request($method, $path);
    }

    /**
     * @link http://rest.websupport.sk/docs/v1.zone#zone
     *
     * Note from docs: if you don't know user ID of currently logged user,
     * you can use string "self", i.e.: path will be "/v1/user/self/zone/:domain_name"
     *
     * @return void
     */
    public function zoneDetails(string $domainName = null, string $method = 'GET'): object
    {
        $domainName = $doaminName ?? $this->domainName;
        $path = join('/', [$this->path, $domainName]);

        return $this->api->request($method, $path);
    }
}
    
/*
DNS zone management resources:

 List of all zones
 Get a zone detail
 
Record management resources: - v DNS\Records

 List of all records
 Get a record detail
 Create a new record
 Update a record
 Delete a record
*/