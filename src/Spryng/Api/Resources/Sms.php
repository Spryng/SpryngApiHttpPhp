<?php

/**
 * Drives Sms functions
 *
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 *
 */
class Spryng_Api_Resources_Sms extends Spryng_Api_Resources_Base
{

    /**
     * @var string URI for the balance Api
     */
    const BALANCE_URI = "/check.php";

    /**
     * @return int
     */
    public function checkBalance ()
    {
        $requestHandler = new Spryng_Api_Utilities_RequestHandler();

        $requestHandler->setHttpMethod("GET");
        $requestHandler->setBaseUrl($this->api->getApiEndpoint());
        $requestHandler->setQueryString(static::BALANCE_URI);
        $requestHandler->setGetParameters([
            'username' => $this->api->getUsername(),
            'password' => $this->api->getPassword()
        ]);
        $requestHandler->doRequest();

        return (int) $requestHandler->getResponse();
    }
}