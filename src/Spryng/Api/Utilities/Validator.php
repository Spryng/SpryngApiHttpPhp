<?php

/**
 * Validates outgoing requests
 *
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 *
 */
class Spryng_Api_Utilities_Validator
{
    static public function validateSendRequest($recipient, $body, $options)
    {
        // Validate recipient
        preg_match('/^[1-9]{1}[0-9]{3,14}$/', $recipient, $match);
        if ( count($match) === 0 )
        {
            throw new Spryng_Api_Exception_InvalidRequestException(
                "Destination is invalid.",
                304
            );
        }

        // Validate sender
        if ( intval($options['sender']) > 0 && strlen($options['sender']) > 14 )
        {
            throw new Spryng_Api_Exception_InvalidRequestException(
                "Numeric senders can not be longer than 14 characters long.",
                306
            );
        }
        else if ( intval($options['sender']) === 0 && strlen($options['sender']) > 11 )
        {
            throw new Spryng_Api_Exception_InvalidRequestException(
                "Alphanumeric senders can not be longer than 11 characters long.",
                305
            );
        }

        // Validate reference
        if ( isset($options['reference']) )
        {
            $ref = $options['reference'];
            if ( strlen($ref) < 1 || strlen($ref) > 256)
            {
                throw new Spryng_Api_Exception_InvalidRequestException(
                    "Reference must be between 1 and 256 characters long.",
                    307
                );
            }
        }

        // Validate length
    }
}