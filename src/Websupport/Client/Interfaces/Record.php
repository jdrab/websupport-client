<?php

declare(strict_types=1);

namespace Websupport\Client\Interfaces;

/**
 * @var		interface	Record
 * @global
 */
interface Record
{
    /**
     * properties.
     *
     * should return all record properties (optional & required)
     * 
     */
    public function properties();

    /**
     * requiredProperties.
     * 
     * should return record required properties
     *
     * @return	void
     */
    public function requiredProperties();

    /**
     * optionalProperties 
     * 
     * should return record optional properties
     *      
     */
    public function optionalProperties();
}
