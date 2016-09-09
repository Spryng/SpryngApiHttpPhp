<?php

/**
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 */

namespace SpryngApiHttpPhp;

/**
 * Class Autoloader
 * @package SpryngApiHttpPhp
 */
class Autoloader
{

    public $directories = array();

    public function __construct($dir, $depth=0)
    {
        $this->autoload_dir(realpath(__DIR__));
    }

    public function autoload_dir($dir)
    {
        $scan = glob($dir."/*");
        $directories = array();

        foreach ($scan as $path)
        {
            if (is_dir($path))
            {
                array_push($directories, $path);
                continue;
            }

            if (preg_match('/\.php$/', $path))
            {
                require_once realpath($path);
            }
        }

        foreach($directories as $dir)
        {
            $this->autoload_dir($dir);
        }
    }

}

$al = new Autoloader(__DIR__, 0);