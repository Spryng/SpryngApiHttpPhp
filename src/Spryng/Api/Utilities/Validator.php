<?php

/**
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 */

namespace SpryngApiHttpPhp\Utilities;

use SpryngApiHttpPhp\Exception\InvalidRequestException;

/**
 * Validates outgoing requests
 *
 * Class Validator
 * @package SpryngApiHttpPhp\Utilities
 */
class Validator
{
    /**
     * Validates the destination phone number
     *
     * @param $recipient string The destination phone number
     * @return string Parsed phone number
     * @throws InvalidRequestException Thrown when the recipient is malformed
     */
    public static function validateMessageRecipient($recipient)
    {
        preg_match('/^[1-9]{1}[0-9]{3,14}$/', $recipient, $match);
        if ( count($match) === 0 )
        {
            throw new InvalidRequestException(
                "Destination is invalid.",
                304
            );
        }

        return $recipient;
    }

    /**
     * Validates message send options. Currently only reference
     *
     * @param $options
     * @param null $body
     * @return mixed
     * @throws InvalidRequestException
     */
    public static function validateSendOptions($options, $body = null)
    {
        // Validate reference
        if ( isset($options['reference']) )
        {
            $ref = $options['reference'];
            if ( strlen($ref) < 1 || strlen($ref) > 256)
            {
                throw new InvalidRequestException(
                    "Reference must be between 1 and 256 characters long.",
                    307
                );
            }
        }

        return $options;
    }
}