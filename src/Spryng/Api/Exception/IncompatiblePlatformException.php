<?php

/**
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 */

namespace SpryngApiHttpPhp\Exception;

use SpryngApiHttpPhp\Exception;

/**
 * Warns if the server does not have the right software installed to use this library.
 *
 * Class IncompatiblePlatformException
 * @package SpryngApiHttpPhp\Exception
 */
class IncompatiblePlatformException extends Exception
{
    const INCOMPATIBLE_PHP_VERSION      = 100;
    const INCOMPATIBLE_CURL_EXTENSION   = 101;
    const INCOMPATIBLE_CURL_FUNCTION    = 102;
    const INCOMPATIBLE_JSON_EXTENSION   = 103;
}