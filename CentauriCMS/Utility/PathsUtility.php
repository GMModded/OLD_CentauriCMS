<?php

namespace CentauriCMS\Centauri\Utility;

class PathsUtility {
    /**
     * Returns rootPath of the server by its APP_URL
     * defined inside .env-file
     * 
     * @return string
     */
    public function rootPath() {
        $appUrl = $_SERVER["APP_URL"];
        return $appUrl . "/";
    }
}
