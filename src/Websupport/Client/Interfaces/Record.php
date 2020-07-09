<?php

declare(strict_types=1);

namespace Websupport\Client\Interfaces;

interface Record
{
    public function path();

    public function properties();

    // public function validate();

    public function requiredProperties();

    public function optionalProperties();
}
