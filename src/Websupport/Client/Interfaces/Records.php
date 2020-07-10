<?php

declare(strict_types=1);

namespace Websupport\Client\Interfaces;

interface Records
{
    public function validate();
    public function create();
    public function update(int $id);
    public function listAll();
    public function delete(int $id);
}
