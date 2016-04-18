<?php

/**
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 */

namespace SpryngApiPhp\Exception;

use SpryngApiPhp\Spryng_Api_Exception;

/**
 * Warns for issues with authentication
 *
 * Class Spryng_Api_Exception_AuthenticationException
 * @package SpryngApiPhp\Exception
 */
class Spryng_Api_Exception_AuthenticationException extends Spryng_Api_Exception
{
    const USERNAME_INVALID_LENGTH   = 201;
    const PASSWORD_INVALID_LENGTH   = 202;
}