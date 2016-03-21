<?php

/**
 * Checks if the server is has the right software installed to use this library.
 *
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 *
 */
class Spryng_Api_Exception_IncompatiblePlatform extends Spryng_Api_Exception
{
    const INCOMPATIBLE_PHP_VERSION      = 1000;
    const INCOMPATIBLE_CURL_EXTENSION   = 2000;
    const INCOMPATIBLE_CURL_FUNCTION    = 2500;
    const INCOMPATIBLE_JSON_EXTENSION   = 3000;
}