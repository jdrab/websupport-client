<?php

declare(strict_types=1);

namespace Websupport\Client\DNS;

use Websupport\Client\DNS\GenericRecord;

class ARecord extends GenericRecord
{
    private array $reqProp = ['type' => 'string', 'name' => 'string', 'content' => 'string'];
    private array $optProp = ['ttl' => 'int'];
    private array $properties;

    public function __construct($properties)
    {
        $this->properties = $properties;
        return $this;
    }

    public function path()
    {
        return $this->path;
    }

    public function properties()
    {
        return $this->properties;
    }
    public function validate()
    {
        return $this->properties;
    }

    public function requiredProperties()
    {
        return $this->reqProp;
    }

    public function optionalProperties()
    {
        return $this->optProp;
    }
}
