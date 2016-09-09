<?php

/**
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 */

namespace SpryngApiHttpPhp;

/**
 * Acts as base for all exceptions
 *
 * Class Exception
 * @package SpryngApiHttpPhp
 */
class Exception extends \Exception
{
    /**
     * @var string
     */
    protected $_field;

    /**
     * Returns the field
     *
     * @return string
     */
    public function getField()
    {
        return $this->_field;
    }

    /**
     * Sets the field
     *
     * @param string $field
     */
    public function setField($field)
    {
        $this->_field = (string) $field;
    }
}