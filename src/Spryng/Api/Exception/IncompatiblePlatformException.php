<?php

/**
 * Checks if the server is has the right software installed to use this library.
 *
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 *
 */
class Spryng_Api_Exception_IncompatiblePlatformException extends Spryng_Api_Exception
{
    const INCOMPATIBLE_PHP_VERSION      = 100;
    const INCOMPATIBLE_CURL_EXTENSION   = 101;
    const INCOMPATIBLE_CURL_FUNCTION    = 102;
    const INCOMPATIBLE_JSON_EXTENSION   = 103;
}