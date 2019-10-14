<?php

/**
 * Allow for controlelrs to use the real Class like: class2controllername(AbcController:class) *
 *
 * @param string $class class reference, using ::class
 * @param string|null $method optional method-name, for non full controller linkings
 *
 * @return string
 */
function class2controllername($class, $method = null)
{
    static $prefix = "App\\Http\\Controllers\\";
    if (strpos($class, $prefix) !== 0) {
        throw new RuntimeException('Trying to use a non controller class as controller: '.$class);
    }

    return substr($class, strlen($prefix)).($method ? '@'.$method : '');
}

