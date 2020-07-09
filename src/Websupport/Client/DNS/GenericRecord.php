<?php

declare(strict_types=1);

namespace Websupport\Client\DNS;

use Websupport\Client\Interfaces\Record as RecordInterface;

class GenericRecord implements RecordInterface
{
    # keys are used for validation, values will be used later
    // private array $pathProp = []
    private array $reqProp = []; //'type' => 'string', 'name' => 'string', 'content' => 'string'];
    private array $optProp = []; //'ttl' => 'int'];
    private array $properties;

    public function __construct($properties)
    {
        $this->properties = $properties;
        // $this->path = null;//'/v1/user/', $this->userId, 'zone', $this->domainName, 'record'];
        // :id/zone/:domain_name/record
    }

    public function path()
    {
        return $this->path;
    }

    public function properties()
    {
        return $this->properties;
    }
    // public function validate()
    // {
    //     return $this->properties;
    // }

    public function requiredProperties()
    {
        return $this->reqProp;
    }

    public function optionalProperties()
    {
        return $this->optProp;
    }
}
