<?php

declare(strict_types=1);

namespace Websupport\Client\DNS;

// 
use Websupport\Client\Request;
use Websupport\Client\DNS;
use Websupport\Client\Interfaces\Records as RecordsInterface;
use Websupport\Client\DNS\GenericRecord;

/**
 * Users
 *
 * @link https://rest.websupport.sk/docs/v1.user
 */
class Records implements RecordsInterface
{

    private object $record;

    private string $path;

    public function __construct(DNS $dns, $record = null, ?int $userId = null)
    {
        $this->dns = $dns;
        $this->record = is_null($record) ? new GenericRecord([]) : $record;
    }

    public function validate()
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

    public function create()
    {

        $path = join(
            '',
            [
                '/v1/user/', $this->dns->userId(),
                '/zone/', $this->dns->domainName(), '/record'
            ]
        );

        return  $this->dns->api->request(
            'POST',
            $path,
            $this->record->properties()
        )->response();
    }


    public function listRecords(?string $domainName = null, string $method = 'GET'): object
    {

        $domainName = $domainName ?? $this->dns->domainName();
        $path = join('', ['/v1/user/', $this->dns->userId(), '/zone/', $domainName, '/record']);

        return $this->dns->api->request(
            $method,
            $path
        );
    }

    public function recordDetails(int $recordId, ?string $domainName = null, string $method = 'GET'): object
    {
        $domainName = $domainName ?? $this->dns->domainName();
        $path = join('', ['/v1/user/', $this->dns->userId(), '/zone/', $domainName, '/record/', $recordId]);

        return $this->dns->api->request($method, $path);
    }
}
