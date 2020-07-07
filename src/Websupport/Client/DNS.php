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
    public function __construct(Request $api, int $id)
    {
        $this->api = $api;
        $this->path = join('/', ['/v1/user', $id]);
        $this->response = null;
    }

    /**
     * @link http://rest.websupport.sk/docs/v1.zone#zones
     *
     * @return void
     */
    public function listZones()
    {
        throw new ClientException('Not implemented');
    }

    /**
     * @link http://rest.websupport.sk/docs/v1.zone#zone
     *
     * @return void
     */
    public function zoneDetails()
    {
        throw new ClientException('Not implemented');
    }

    /**
     * @link http://rest.websupport.sk/docs/v1.zone#records
     *
     * @return void
     */
    public function listRecords()
    {
        throw new ClientException('Not implemented');
    }

    /**
     * @link http://rest.websupport.sk/docs/v1.zone#record
     *
     * @return void
     */
    public function recordDetails()
    {
        throw new ClientException('Not implemented');
    }

    /**
     * @link http://rest.websupport.sk/docs/v1.zone#post-record
     *
     * @return void
     */
    public function addRecord()
    {
        throw new ClientException('Not implemented');
    }

    /**
     * @link http://rest.websupport.sk/docs/v1.zone#put-record
     *
     * @return void
     */
    public function updateRecord()
    {
        throw new ClientException('Not implemented');
    }

    /**
     * @link http://rest.websupport.sk/docs/v1.zone#delete-record
     *
     * @return void
     */
    public function deleteRecord()
    {
        throw new ClientException('Not implemented');
    }
}

/*
DNS zone management resources:

 List of all zones
 Get a zone detail
 
Record management resources:

 List of all records
 Get a record detail
 Create a new record
 Update a record
 Delete a record
*/