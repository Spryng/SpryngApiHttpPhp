<?php

/**
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 */

namespace SpryngApiHttpPhp;

/**
 * Used to autoload all classes when not installed with Composer.
 *
 * Class Autoloader
 * @package SpryngApiHttpPhp
 */
class Autoloader
{

    /**
     * To temporarily store directory names.
     * @var array
     */
    public $directories = array();

    /**
     * Autoloader constructor.
     * @param $dir
     * @param int $depth
     */
    public function __construct($dir, $depth=0)
    {
        $this->autoload_dir(realpath(__DIR__));
    }

    /**
     * Autoloads all classes
     * @param $dir
     */
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