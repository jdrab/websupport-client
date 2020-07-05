<?php

declare(strict_types=1);

namespace Websupport\Client;

use Websupport\Client\Request;
use Websupport\Client\Exception as ClientException;

/**
 * Users
 *
 * @link https://rest.websupport.sk/docs/v1.user
 */
class Users
{

    private $api;

    /**
     * __construct
     *
     * @param  \Websupport\Client\Request $api
     * @return void
     */
    public function __construct(Request $api)
    {
        $this->api = $api;
    }



    /**
     * listAll
     *
     * @link https://rest.websupport.sk/docs/v1.user#users
     *
     * @param  mixed $path
     * @param  mixed $method
     * @return object
     */
    public function listAll($path = '/v1/user', $method = 'GET'): object
    {
        return $this->api->request($method, $path);
    }


    /**
     * Whoami
     *
     * get info about currently logged user - https://rest.websupport.sk/v1/user/self
     * @link https://rest.websupport.sk/docs/v1.user#user
     * @return void
     */
    public function whoami()
    {
        throw new ClientException('Not implemented');
    }


    /**
     * getUserDetails
     *
     * @link /**
     * Whoami
     *
     * @link https://rest.websupport.sk/docs/v1.user#user
     */
    public function getDetails()
    {
        throw new ClientException('Not implemented');
    }

    /**
     * create
     *
     * @link https://rest.websupport.sk/docs/v1.user#post-user
     * @return void
     */
    public function create()
    {
        throw new ClientException('Not implemented');
    }



    /**
     * update
     *
     * @link https://rest.websupport.sk/docs/v1.user#put-user
     * @return void
     */
    public function update()
    {
        throw new ClientException('Not implemented');
    }


    /**
     * resetPassword
     *
     * @link https://rest.websupport.sk/docs/v1.user#pass-reset
     * @return void
     */
    public function resetPassword()
    {
        throw new ClientException('Not implemented');
    }

    /*
    User management resources:

        List of all users - done
        Get a user detail - done
        Create a new user
        Update user
        Password reset

    Billing profile management resources:

        List of all billing profiles
        Get a billing profile detail
        Create a new billing profile
        Update billing profile
        Delete billing profile

    Domain profile management resources:

        List of all domain profiles
        Get a domain profile
        Create new domain profile
        Update domain profile
        Delete domain profile

     */
}
