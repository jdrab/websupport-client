<?php

declare(strict_types=1);

namespace Websupport\Client\DNS;

use Websupport\Client\DNS\GenericRecord;

class ARecord extends GenericRecord
{
    /**
     * @var		array	$defaultProp
     */
    private array $defaultProp = ['type' => 'A'];

    /**
     * @var	    array	$reqProp Required type(dns) properties
     * @link    https://rest.websupport.sk/docs/v1.zone#post-record
     */
    private array $reqProp = ['name' => 'string', 'content' => 'string'];

    /**
     * @var		array	$optProp Optional properties
     * @link    https://rest.websupport.sk/docs/v1.zone#post-record
     */

    private array $optProp = ['ttl' => 'int'];

    /**
     * @var		array	$properties merged defautl and user provided properties
     */
    private array $properties;

    public function __construct($properties)
    {
        // default properties must override user provided properties - eg: type
        $this->properties = array_merge($properties, $this->defaultProp);
        return $this;
    }

    /**
     * properties.
     *
     * @return	array
     */
    public function properties(): array
    {
        return $this->properties;
    }
    /**
     * validate.
     *
     * @return	array
     */
    public function validate(): array
    {
        return $this->properties;
    }

    /**
     * requiredProperties.
     *
     * @return	array
     */
    public function requiredProperties(): array
    {
        return $this->reqProp;
    }

    /**
     * optionalProperties.
     *
     * @return	array
     */
    public function optionalProperties(): array
    {
        return $this->optProp;
    }
}
