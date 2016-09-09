<?php

/**
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 */

namespace SpryngApiHttpPhp;

use SpryngApiHttpPhp\Exception\IncompatiblePlatformException as IncompatiblePlatform;

/**
 * Checks if the server is has the right software installed to use this library.
 *
 * Class Spryng_Api_CompatibilityChecker
 * @package SpryngApiHttpPhp
 */
class CompatibilityChecker
{
    /**
     * Minimum required PHP version
     *
     * @var string
     */
    public static $MIN_PHP_VERSION = '5.2.0';

    /**
     * @var array
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
     * Checks if the server satisfies all system requirements
     *
     * @throws IncompatiblePlatform
     * @return void
     */
    public function checkCompatibility()
    {
        if (!$this->satisfiesPhpVersion())
        {
            throw new IncompatiblePlatform(
                "The client requires PHP version >= " . self::$MIN_PHP_VERSION . ", you have " . PHP_VERSION . ".",
               IncompatiblePlatform::INCOMPATIBLE_PHP_VERSION
            );
        }

        if (!$this->satisfiesJsonExtension())
        {
            throw new IncompatiblePlatform(
                "PHP extension json is not enabled. Please make sure to enable 'json' in your PHP configuration.",
                IncompatiblePlatform::INCOMPATIBLE_JSON_EXTENSION
            );
        }

        if (!$this->satisfiesCurlExtension())
        {
            throw new IncompatiblePlatform(
                "PHP extension cURL is not enabled. Please make sure to enable 'cURL' in your PHP configuration.",
                IncompatiblePlatform::INCOMPATIBLE_CURL_EXTENSION
            );
        }

        if (!$this->satisfiesCurlFunctions())
        {
            throw new IncompatiblePlatform(
                "This client requires the following cURL functions to be available: " . implode(', ', self::$REQUIRED_CURL_FUNCTIONS) . ". ".
                "Please check that none of these function are disabled in your PHP configuration.",
                IncompatiblePlatform::INCOMPATIBLE_CURL_FUNCTION
            );
        }
    }

    /**
     * Checks if the server's PHP installation satisfies the requirement
     *
     * @return bool
     */
    public function satisfiesPhpVersion ()
    {
        return (bool) version_compare(PHP_VERSION, self::$MIN_PHP_VERSION, '>=');
    }

    /**
     * Checks if the PHP JSON extension is loaded
     *
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
     * Checks if the PHP cURL extension is loaded
     *
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
     * Checks if the required cURL functions are available
     *
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