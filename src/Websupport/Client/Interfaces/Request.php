<?php

declare(strict_types=1);

namespace Websupport\Client\Interfaces;

interface Request
{
    /**
     * init
     *
     * @param  mixed $path
     * @param  mixed $time
     * @return void
     */
    public function init(string $path, int $time);

    /**
     * sign
     *
     * @param  mixed $method
     * @param  mixed $path
     * @param  mixed $time
     * @return void
     */
    public function sign(string $method, string $path, int $time);

    /**
     * prepareRequest
     *
     * @param  mixed $method
     * @param  mixed $path
     * @return void
     */
    public function request(string $method, string $path);

    /**
     * response
     *
     * @return void
     */
    public function response();
}
