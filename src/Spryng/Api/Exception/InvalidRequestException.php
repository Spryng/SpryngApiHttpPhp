<?php

/**
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 */

namespace SpryngApiHttpPhp\Exception;

use SpryngApiHttpPhp\Exception;

/**
 * Warns for invalid requests
 *
 * Class Spryng_Api_Exception_InvalidRequestException
 * @package SpryngApiHttpPhp\Exception
 */
class InvalidRequestException extends Exception
{
    const INVALID_CLIENT                        = 301;
    const BODY_TOO_LONG_WITHOUT_ALLOWLONG       = 302;
    const BODY_TOO_LONG                         = 303;
    const INVALID_DESTINATION                   = 304;
    const ALPHANUMERIC_SENDER_TOO_LONG          = 305;
    const NUMERIC_SENDER_TOO_LONG               = 306;
    const REFERENCE_INVALID_LENGTH              = 307;
    const UNKNOWN                               = 0;
}