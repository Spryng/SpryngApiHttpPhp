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
     * @var string URI for the send Api
     */
    const SMS_URI = "/send.php";

    /**
     * @var array
     */
    private $routes = ['BUSINESS', 'ECONOMY'];

    public $defaultSendOptions = array(
        'sender'    => '',
        'route'     => 'ECONOMY',
        'allowlong' => false
    );

    public function send($recipient, $body, $options)
    {
        // Prepare the request
        $requestHandler = new Spryng_Api_Utilities_RequestHandler();
        $requestHandler->setHttpMethod("GET");
        $requestHandler->setBaseUrl($this->api->getApiEndpoint());
        $requestHandler->setQueryString(static::SMS_URI);
        $requestHandler->addGetParameter('send', 'OPERATION', false);
        $requestHandler->addGetParameter($this->api->getUsername(), 'USERNAME', false);
        $requestHandler->addGetParameter($this->api->getPassword(), 'PASSWORD', false);

        // Testing recipient for MSISDN validity
        preg_match('/^[1-9]{1}[0-9]{3,14}$/', $recipient, $match);

        // Check if recipient is valid
        if (count($match) > 0)
        {
            $requestHandler->addGetParameter($recipient, 'DESTINATION', false);
        }
        else
        {
            throw new Spryng_Api_Exception_InvalidRequestException(
                "Destination is invalid.",
                304
            );
        }

        if (isset($options['sender']))
        {
            if (intval($options['sender']) > 0 && strlen($options['sender']) > 14)
            {
                throw new Spryng_Api_Exception_InvalidRequestException(
                    "Numeric senders can not be longer than 14 characters long.",
                    306
                );
            }
            else if (intval($options['sender']) === 0 && strlen($options['sender']) > 11)
            {
                throw new Spryng_Api_Exception_InvalidRequestException(
                    "Alphanumeric senders can not be longer than 11 characters long.",
                    305
                );
            }
            else
            {
                $requestHandler->addGetParameter($options['sender'], 'SENDER', true);
            }
        }

        // Check if user specified a valid client. If no client was specified, use default
        if (isset($options['route']))
        {
            if (!in_array(strtoupper($options['route']), $this->routes))
            {
                throw new Spryng_Api_Exception_InvalidRequestException(
                    "The client you're trying to use does not exist.",
                    301
                );
            }
            else
            {
                $requestHandler->addGetParameter(strtoupper($options['route']), 'ROUTE', true);
            }
        }
        else
        {
            $requestHandler->addGetParameter($this->defaultSendOptions['route'], 'ROUTE', false);
        }

        // Add optional reference
        if (isset($options['reference']))
        {
            $requestHandler->addGetParameter($options['reference'], 'REFERENCE', true);
        }

        if (isset($options['allowlong']))
        {
            if ($options['allowlong'])
            {
                // Check for length requirement
                if (strlen($body) > 612)
                {
                    throw new Spryng_Api_Exception_InvalidRequestException(
                        "Maximum length for body is 612 characters.",
                        303
                    );
                }
                else
                {
                    $requestHandler->addGetParameter($body, 'BODY', true);
                    $requestHandler->addGetParameter($options['allowlong'], 'ALLOWLONG', false);
                }
            }
            else
            {
                // Check for length requirement if allowlong is dissabled
                if (strlen($body) > 160 && !$options['allowlong'])
                {
                    throw new Spryng_Api_Exception_InvalidRequestException(
                        "Body can't be longer than 160 characters without 'allowlong' enabled.",
                        302
                    );
                }
                else
                {
                    $requestHandler->addGetParameter($body, 'BODY', true);
                    $requestHandler->addGetParameter($options['allowlong'], 'ALLOWLONG', false);
                }
            }
        }
        else
        {
            $requestHandler->addGetParameter($body, 'BODY', true);
            $requestHandler->addGetParameter($this->defaultSendOptions['allowlong'], 'ALLOWLONG', false);
        }

        $requestHandler->doRequest();

        return $requestHandler->getResponse();
    }

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
        ], true);
        $requestHandler->doRequest();

        return (int) $requestHandler->getResponse();
    }
}