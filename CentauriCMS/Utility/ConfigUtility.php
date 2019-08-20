<?php

namespace CentauriCMS\Centauri\Utility;

class ConfigUtility {
    public static function get() {
        return (include "CentauriCMS/config.php");
    }
}
