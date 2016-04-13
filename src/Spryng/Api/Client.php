<?php

/**
 * Acts as driver for the application
 *
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 *
 */
class Spryng_Api_Client
{
    /**
     * @var string Version of this client
     */
    const CLIENT_VERSION = "0.1";

    /**
     * @var string Endpoint for all Api requests
     */
    const API_ENDPOINT = "http://spryng.nl";

    protected $apiEndpoint = self::API_ENDPOINT;

    /**
     * @var Spryng_Api_Resource_Sms
     */
    public $sms;

    /**
     * @var string Username for the service
     */
    protected $username;

    /**
     * @var string Password for the service
     */
    protected $password;

    /**
     * Spryng_Api_Client constructor.
     * @param $username string
     * @param $password string
     */
    public function __construct ($username, $password)
    {
        $this->getCompatibilityChecker()->checkCompatibility();

        $this->setCredentials($username, $password);

        $this->sms = new Spryng_Api_Resources_Sms($this);
    }

    /**
     * Checks format of username and password.
     *
     * @param $username
     * @param $password
     * @throws Spryng_Api_Exception_AuthenticationException
     */
    public function setCredentials( $username, $password )
    {
        if (strlen($username) < 2 || strlen($username) > 32)
        {
            throw new Spryng_Api_Exception_AuthenticationException(
                "Username must be between 2 and 32 characters.",
                201
            );
        }
        if (strlen($password) < 6 || strlen($password) > 32)
        {
            throw new Spryng_Api_Exception_AuthenticationException(
                "Password must be between 6 and 32 characters.",
                202
            );
        }

        $this->setUsername($username);
        $this->setPassword($password);
    }

    /**
     * @return Spryng_Api_CompatibilityChecker
     */
    protected function getCompatibilityChecker ()
    {
        static $checker = NULL;
        if (!$checker)
        {
            $checker = new Spryng_Api_CompatibilityChecker();
        }
        return $checker;
    }

    /**
     * @return string
     */
    public function getApiEndpoint()
    {
        return $this->apiEndpoint;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}