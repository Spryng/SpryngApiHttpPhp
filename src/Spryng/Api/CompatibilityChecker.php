<?php

/**
 * Checks if the server is has the right software installed to use this library.
 *
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 *
 */

class Spryng_Api_CompatibilityChecker
{
    /**
     * @var string
     */
    public static $MIN_PHP_VERSION = '5.2.0';

    /**
     * Required cURL functions
     */
    public static $REQUIRED_CURL_FUNCTIONS = array(
        'curl_init',
        'curl_setopt',
        'curl_exec',
        'curl_error',
        'curl_errno',
        'curl_close',
        'curl_version'
    );

    /**
     * @throws Spryng_Api_Exception_IncompatiblePlatform
     * @return void
     */
    public function checkCompatibility()
    {
        if (!$this->satisfiesPhpVersion())
        {
            throw new Spryng_Api_Exception_IncompatiblePlatform(
                "The client requires PHP version >= " . self::$MIN_PHP_VERSION . ", you have " . PHP_VERSION . ".",
                Spryng_Api_Exception_IncompatiblePlatform::INCOMPATIBLE_PHP_VERSION
            );
        }

        if (!$this->satisfiesJsonExtension())
        {
            throw new Spryng_Api_Exception_IncompatiblePlatform(
                "PHP extension json is not enabled. Please make sure to enable 'json' in your PHP configuration.",
                Spryng_Api_Exception_IncompatiblePlatform::INCOMPATIBLE_JSON_EXTENSION
            );
        }

        if (!$this->satisfiesCurlExtension())
        {
            throw new Spryng_Api_Exception_IncompatiblePlatform(
                "PHP extension cURL is not enabled. Please make sure to enable 'cURL' in your PHP configuration.",
                Spryng_Api_Exception_IncompatiblePlatform::INCOMPATIBLE_CURL_EXTENSION
            );
        }

        if (!$this->satisfiesCurlFunctions())
        {
            throw new Spryng_Api_Exception_IncompatiblePlatform(
                "This client requires the following cURL functions to be available: " . implode(', ', self::$REQUIRED_CURL_FUNCTIONS) . ". ".
                "Please check that none of these function are disabled in your PHP configuration.",
                Spryng_Api_Exception_IncompatiblePlatform::INCOMPATIBLE_CURL_FUNCTION
            );
        }
    }

    /**
     * @return bool
     */
    public function satisfiesPhpVersion ()
    {
        return (bool) version_compare(PHP_VERSION, self::$MIN_PHP_VERSION, '>=');
    }

    /**
     * @return bool
     */
    public function satisfiesJsonExtension()
    {
        if (function_exists('extension_loaded') && extension_loaded('json')) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function satisfiesCurlExtension()
    {
        if (function_exists('extension_loaded') && extension_loaded('curl')) {
            return true;
        }
        elseif (function_exists('curl_version') && curl_version()) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function satisfiesCurlFunctions()
    {
        foreach(self::$REQUIRED_CURL_FUNCTIONS as $curl_function) {
            if (!function_exists($curl_function))
            {
                return false;
            }
        }

        return true;
    }
}