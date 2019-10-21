<?php

namespace CentauriCMS\Centauri\Blade\Helper;

use Illuminate\Support\Facades\URL;

class LanguageHelper {
    public static function languages() {
        $languageComponent = new \CentauriCMS\Centauri\Component\LanguageComponent;
        $languages = $languageComponent->findAll(true);

        $baseurl = URL::to("/");
        $currenturl = URL::current();

        foreach($languages as $language) {
            $language->url = str_replace($baseurl, "" . $language->shortcut, $currenturl);
            $language->rendered = "<a href='" . $language->url . "'>" . $language->shortcut . "</a>";
        }

        return $languages;
    }
}
