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

    private int $userId;
    private int $parentId;
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
        $this->path = '/v1/user';
        $this->response = null;
        $this->userId = 0;

        return $this;
    }

    /**
     * userId.
     *
     * @return	int
     */
    public function userId(): int
    {
        return $this->userId;
    }

    /**
     * parentId
     *
     * @return	int
     */
    public function parentId(): int
    {
        return $this->parentId;
    }


    /**
     * listAll
     *
     * @link https://rest.websupport.sk/docs/v1.user#users
     *
     * @todo optional parameters 'page' and 'pagesize' are not implemented
     * @param  mixed $method
     * @param  mixed $path
     * @return object
     */
    public function listAll(string $method = 'GET'): object
    {
        return $this->api->request($method, $this->path);
    }

    /**
     * setUserId.
     *
     * @param	int	$id	
     * @return	object
     */
    public function setUserId(int $id): object
    {
        $this->userId = $id;
        return $this;
    }

    /**
     * setParentId.
     *
     * @param	int	$parentId
     * @return	object
     */
    public function setParentId(int $parentId): object
    {
        $this->parentId = $parentId;
        return $this;
    }

    /**
     * Whoami
     *
     * get info about currently logged user - https://rest.websupport.sk/v1/user/self
     * @link https://rest.websupport.sk/docs/v1.user#user
     * 
     * @var string $method Supported HTTP Method
     * @return object
     */
    public function whoami(string $method = 'GET'): object
    {
        $path = join('/', [$this->path, 'self']);
        $resp = $this->api->request($method, $path);

        $data = json_decode($resp->response());

        $this->setUserId($data->id);
        if (!is_null($data->parentId)) {
            $this->setParentId($data->parentId);
        }

        return $resp;
    }


    /**
     * details
     *
     * @param	int   	$id userId
     * @param	string	$method	HTTP method Default: 'GET'
     * @return	object
     */
    public function details(int $id, string $method = 'GET'): object
    {
        $path = $path ?? join('/', [$this->path, $id]);

        return $this->api->request($method, $path);
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

        [x] List of all users
        [x] Get info about self
        [x] Get a user detail
        [ ] Create a new user
        [ ] Update user
        [ ] Password reset

    Billing profile management resources: - separate class

        [ ] List of all billing profiles
        [ ] Get a billing profile detail
        [ ] Create a new billing profile
        [ ] Update billing profile
        [ ] Delete billing profile

    Domain profile management resources: - separate class

        [ ] List of all domain profiles
        [ ] Get a domain profile
        [ ] Create new domain profile
        [ ] Update domain profile
        [ ] Delete domain profile

     */
}
