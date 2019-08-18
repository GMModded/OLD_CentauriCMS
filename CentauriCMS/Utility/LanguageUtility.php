<?php

namespace CentauriCMS\Centauri\Utility;

use Illuminate\Support\Facades\App;

class LanguageUtility {
    /**
     * Returns a list of existing languages via ConfigUtility from CentauriCMS
     */
    public function findAll() {
        $config = \CentauriCMS\Centauri\Utility\ConfigUtility::get();
        return $config["language"]["list"];
    }

    /**
     * Updates the current language for the current request
     * 
     * @param $request
     * @param string $fallbackLanguage
     * 
     * @return void
     */
    public function updateLanguage($request, $fallbackLanguage) {
        $config = \CentauriCMS\Centauri\Utility\ConfigUtility::get();

        if(!$fallbackLanguage) $fallbackLanguage = $config["language"]["fallback"];

        $language = $request->input("language") ?? $fallbackLanguage;
        App::setLocale($language);
    }
}
