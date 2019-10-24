<?php

namespace CentauriCMS\Centauri\Helper;

class HookHelper {
    public static function callHook($hook, $params = null) {
        $char = "::";

        if(strpos("->", $hook) !== false) {
            $char = "->";
        }

        $hookData = explode($char, $hook);

        $class = $hookData[0];
        $method = $hookData[1];

        $Centauri = new \CentauriCMS\Centauri\Centauri;

        return call_user_func([
            $Centauri::makeInstance($class),
            ucfirst($method)
        ], $params);
    }
}
