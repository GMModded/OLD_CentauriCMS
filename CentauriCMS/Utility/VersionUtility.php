<?php

namespace CentauriCMS\Centauri\Utility;

class VersionUtility {
    /**
     * Returns the version by the given name
     * 
     * @param string $name
     * 
     * @return string
     */
    public static function findByName($name) {
        $config = \CentauriCMS\Centauri\Utility\ConfigUtility::get();
        return isset($config["version"][$name]) ? $config["version"][$name] : "null";
    }
}
