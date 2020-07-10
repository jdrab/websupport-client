<?php

declare(strict_types=1);

namespace Websupport\Client\DNS;

use Websupport\Client\Interfaces\Record as RecordInterface;

class GenericRecord implements RecordInterface
{
    private array $defaultProp = [];
    private array $reqProp = [];
    private array $optProp = [];
    private array $properties;

    public function __construct($properties)
    {
        $this->properties = array_merge($properties, $this->defaultProp);
    }

    public function properties()
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
