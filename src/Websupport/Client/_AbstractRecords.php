<?php

declare(strict_types=1);

namespace Websupport\Client;

abstract class AbstractRecords
{
    private array $reqProp;

    private array $optProp;

    public function setRequiredProps(array $properties)
    {
        $this->reqProp = $properties;
    }
    public function setOptionalProps(array $properties)
    {
        $this->optProp = $properties;
    }

    abstract function validate();
    abstract function create();
}
