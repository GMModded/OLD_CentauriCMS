<?php

namespace CentauriCMS\Centauri;

class Centauri {
    /**
     * Makes an instance of the given $class param
     * 
     * @param class $class
     * 
     * @return class
     */
    public static function makeInstance($class) {
        return new $class;
    }
}
