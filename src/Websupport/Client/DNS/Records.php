<?php

declare(strict_types=1);

namespace Websupport\Client\DNS;

use Websupport\Client\DNS;
use Websupport\Client\Interfaces\Records as RecordsInterface;
use Websupport\Client\DNS\GenericRecord;

/**
 * Users
 *
 * @link https://rest.websupport.sk/docs/v1.zone
 */
class Records implements RecordsInterface
{

    /**
     * @var     \Websupport\Client\DNS	$dns - holds some required params like domainName
     */
    private object $dns;


    /**
     * @var	    \Websupport\Client\DNS\GenericRecord|null	$record 
     */
    private $record;


    /**
     * Records
     *
     * @param Websupport\Client\DNS $dns
     * @param mixed Websupport\Client\DNS\GenericRecord|null $record
     * @param integer|null $userId - websupport user id
     */
    public function __construct(DNS $dns, $record = null, ?int $userId = null)
    {
        $this->dns = $dns;
        $this->record = $record ?? new GenericRecord([]);
        return $this;
    }

    /**
     * validate record definition
     *
     * @see $this->create()
     * 
     * @todo validate property type
     * @access	public
     * @return	object
     */
    public function validate(): object
    {
        $missingProps = array_diff(
            array_keys($this->record->requiredProperties()),
            array_keys($this->record->properties())
        );

        if ($missingProps) {
            throw new RecordException("Invalid record defition, missing required properties:" . join(",", $missingProps));
        }

        return $this;
    }

    /**
     * create record
     *
     * Record is created with properties defined in second Records __constructor arg
     * 
     * @link http://rest.websupport.sk/docs/v1.zone#post-record
     * 
     * <code>
     * $restUrl = "https://rest.websupport.sk";
     * $ws = new \Websupport\Client\Request($restUrl, $apiKey, $secret);
     * $dns = new \Websupport\Client\DNS($ws, $domainName);
     * $records = new \Websupport\Client\DNS\Records(
     *     $dns,
     *     new \Websupport\Client\DNS\ARecord(['name' => 'work2', 'content' => $ip])
     * );
     * 
     * $x = $records->validate()->create();
     * </code>
     * 
     * @access	public
     * @return	string
     */
    public function create(): object
    {

        $path = join(
            '',
            [
                '/v1/user/',
                $this->dns->userId(),
                '/zone/',
                $this->dns->domainName(),
                '/record'
            ]
        );

        return  $this->dns->api->request(
            'POST',
            $path,
            $this->record->properties()
        );
    }


    /**
     * update record
     *
     * @link http://rest.websupport.sk/docs/v1.zone#put-record
     * 
     * @access	public
     * @param	int	    $recordId - must be id, not a name, ws docs are missleading
     * @return	string
     */
    public function update(int $recordId): object
    {

        $path = join(
            '',
            [
                '/v1/user/',
                $this->dns->userId(),
                '/zone/',
                $this->dns->domainName(),
                '/record/',
                $recordId
            ]
        );

        return $this->dns->api->request(
            'PUT',
            $path,
            $this->record->properties()
        );
    }

    /**
     * delete record
     *
     * @link    http://rest.websupport.sk/docs/v1.zone#delete-record
     *
     * <code>
     * $restUrl = "https://rest.websupport.sk";
     * $ws = new \Websupport\Client\Request($restUrl, $apiKey, $secret);
     * $dns = new \Websupport\Client\DNS($ws, $domainName);
     * $record = new \Websupport\Client\DNS\Records(
     *     $dns
     * );
     * $delete = $record->delete($recordId); 
     * </code>
     * 
     * @access	public
     * @param	int	$recordId	
     * @return	object
     */
    public function delete(int $recordId): object
    {


        $path = join(
            '',
            [
                '/v1/user/',
                $this->dns->userId(),
                '/zone/',
                $this->dns->domainName(),
                '/record/',
                $recordId
            ]
        );

        return $this->dns->api->request(
            'DELETE',
            $path,
            $this->record->properties()
        );
    }

    /**
     * listAll
     * 
     * Lists all defined records for provided domain.
     *
     * <code>
     * $restUrl = "https://rest.websupport.sk";
     * $ws = new \Websupport\Client\Request($restUrl, $apiKey, $secret);
     * $dns = new \Websupport\Client\DNS($ws, $domainName);
     * $records = new \Websupport\Client\DNS\Records($dns);
     * echo "listRecords:" . $records->listAll()->response();
     * </code>
     * 
     * or
     * 
     * <code>
     * $restUrl = "https://rest.websupport.sk";
     * $ws = new \Websupport\Client\Request($restUrl, $apiKey, $secret);
     * $dns = new \Websupport\Client\DNS($ws);
     * $records = new \Websupport\Client\DNS\Records($dns);
     * echo "listRecords:" . $records->listAll($domainName)->response();
     * </code>
     * 
     * @access	public
     * @param	string	$domainName	Default: null
     * @return	mixed
     */
    public function listAll(?string $domainName = null): object
    {

        $domainName = $domainName ?? $this->dns->domainName();
        $path = join('', [
            '/v1/user/',
            $this->dns->userId(),
            '/zone/',
            $domainName,
            '/record'
        ]);

        return $this->dns->api->request(
            'GET',
            $path
        );
    }

    /**
     * details.
     * 
     * <code>
     * $restUrl = "https://rest.websupport.sk";
     * $ws = new \Websupport\Client\Request($restUrl, $apiKey, $secret);
     * $dns = new \Websupport\Client\DNS($ws, $domainName);
     * $records = new \Websupport\Client\DNS\Records($dns);
     * echo "record details: " . $records->details(13107849)->prettyResponse();
     * </code>
     * 
     * @param	int 	$recordId  	
     * @param	string	$domainName	Default: null
     * @param	string	$method    	Default: 'GET'
     * @return	mixed
     */
    public function details(int $recordId, ?string $domainName = null, string $method = 'GET'): object
    {
        $domainName = $domainName ?? $this->dns->domainName();
        $path = join('', [
            '/v1/user/',
            $this->dns->userId(),
            '/zone/',
            $domainName,
            '/record/',
            $recordId
        ]);

        return $this->dns->api->request($method, $path);
    }
}

/*
Record management resources: - DNS\Records

 [x] List of all records
 [x] Get a record detail
 [x] Create a new record
 [x] Update a record
 [x] Delete a record
*/