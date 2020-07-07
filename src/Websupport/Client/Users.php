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
    }

    /**
     * userId.
     *
     * @return	int
     */
    public function userId()
    {
        return $this->userId;
    }

    /**
     * parentId
     *
     * @return	int
     */
    public function parentId()
    {
        return $this->parentId;
    }


    /**
     * listAll
     *
     * @link https://rest.websupport.sk/docs/v1.user#users
     *
     * @param  mixed $method
     * @param  mixed $path
     * @return object
     */
    public function listAll(string $method = 'GET', string $path = null): object
    {
        $path = $path ?? $this->path;

        return $this->api->request($method, $path);
    }

    /**
     * setUserId.
     *
     * @access	public
     * @param	int	$id	
     * @return	void
     */
    public function setUserId(int $id)
    {
        $this->userId = $id;
        return $this;
    }

    public function setParentId(int $parentId): void
    {
        $this->parentId = $parentId;
    }

    /**
     * Whoami
     *
     * get info about currently logged user - https://rest.websupport.sk/v1/user/self
     * @link https://rest.websupport.sk/docs/v1.user#user
     * 
     * @var string $method Supported HTTP Method
     * @var string $path Endpoint path
     * @return object
     */
    public function whoami(string $method = 'GET', string $path = null): object
    {
        $path = $path ?? join('/', [$this->path, 'self']);
        $resp = $this->api->request($method, $path);

        $data = json_decode($resp->response());

        $this->setUserId($data->id);
        $this->setParentId($data->parentId);
        return $resp;
    }


    /**
     * userDetails
     *
     *
     * @link https://rest.websupport.sk/docs/v1.user#user
     * 
     * @var string $method Supported HTTP Method
     * @var string $path Endpoint path
     * @return object
     */
    public function userDetails(int $id, string $method = 'GET', string $path = null): object
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

        List of all users - done
        Get info about self - done
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
