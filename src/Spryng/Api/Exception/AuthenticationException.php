<?php

/**
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 */

namespace SpryngApiHttpPhp\Exception;

use SpryngApiHttpPhp\Exception;

/**
 * Warns for issues with authentication
 *
 * Class AuthenticationException
 * @package SpryngApiHttpPhp\Exception
 */
class AuthenticationException extends Exception
{
    const USERNAME_INVALID_LENGTH   = 201;
    const PASSWORD_INVALID_LENGTH   = 202;
}