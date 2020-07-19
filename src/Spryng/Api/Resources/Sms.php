<?php

/**
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 */

namespace SpryngApiHttpPhp\Resources;

use SpryngApiHttpPhp\Utilities\Validator;
use SpryngApiHttpPhp\Utilities\RequestHandler;
use SpryngApiHttpPhp\Exception\InvalidRequestException;

/**
 * Drives SMS functions
 *
 * Class Spryng_Api_Resources_Sms
 * @package SpryngApiHttpPhp\Resources
 */
class Sms extends Base
{

    /**
     * @var string URI for the balance Api
     */
    const BALANCE_URI = "/balance";

    /**
     * @var string URI for the send Api
     */
    const SMS_URI = "/message";

    /**
     * Defaults for optional parameters in send method
     *
     * @var array
     */
    public $defaultSendOptions = array(
        'route'         => 'business'
    );

    /**
     * Used to send text messages
     *
     * @param $recipient string
     * @param $body string
     * @param $options array
     * @return mixed string
     * @throws InvalidRequestException
     */
    public function send($recipient, $body, $options)
    {
        if (! isset( $options['route']) )
        {
            $options['route'] = $this->defaultSendOptions['route'];
        }

        try {
            $options = Validator::validateSendOptions($options, $body);
            $recipient = Validator::validateMessageRecipient($recipient);
        } catch (\Exception $e) {
            throw new InvalidRequestException('Request malformed: '. $e->getMessage());
        }

        // Prepare the request
        $requestHandler = new RequestHandler();
        $requestHandler->setHttpMethod("POST");
        $requestHandler->setBaseUrl($this->api->getApiEndpoint());
        $requestHandler->setQueryString(static::SMS_URI);
        $requestHandler->addGetParameter($this->api->getUsername(), 'username', false);

        // Add either PASSWORD or SECRET accordingly
        $auth = $this->api->getIsSecret() ? 'secret' : 'password';
        $requestHandler->addGetParameter($this->api->getPassword(), $auth, false);

        $requestHandler->addGetParameter($recipient, 'destination', true);
        $requestHandler->addGetParameter($this->api->getSender(), 'sender', true);
        $requestHandler->addGetParameter($body, 'body', true);
        $requestHandler->addGetParameter($options['route'], 'route', true);

        // Add optional reference
        if ( isset($options['reference']) )
        {
            $requestHandler->addGetParameter($options['reference'], 'reference', true);
        }


        $requestHandler->doRequest();

        return $requestHandler->getResponse();
    }

    /**
     * Returns the remaining credit balance
     *
     * @return int
     */
    public function checkBalance ()
    {
        $requestHandler = new RequestHandler();

        $requestHandler->setHttpMethod("POST");
        $requestHandler->setBaseUrl($this->api->getApiEndpoint());
        $requestHandler->setQueryString(static::BALANCE_URI);
        $requestHandler->setGetParameters([
            'username' => $this->api->getUsername(),
            'password' => $this->api->getPassword()
        ], true);
        $requestHandler->doRequest();

        return $requestHandler->getResponse();
    }
}
