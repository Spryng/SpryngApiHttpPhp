<?php

/**
 * Drives Sms functions
 *
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 *
 */
class Spryng_Api_Resources_Base
{

    /**
     * @var Spryng_Api_Client
     */
    protected $api;

    /**
     * @var string
     */
    protected $resourcePath;

    /**
     * Spryng_Api_Resource_Base constructor.
     * @param Spryng_Api_Client $api
     */
    public function __construct (Spryng_Api_Client $api)
    {
        $this->api = $api;

        if (empty($this->resourcePath))
        {
            $class_parts         = explode("_", get_class($this));
            $this->resourcePath = strtolower(end($class_parts));
        }
    }
}