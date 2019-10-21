<?php

namespace CentauriCMS\Centauri\Component;

use \Illuminate\Support\Facades\DB;

class LanguageComponent {
    public function findAll($respectHidden = 0) {
        $languages = DB::table("languages")->select("*")->get();

        if($respectHidden) {
            $languages = DB::table("languages")->select("*")->where("hidden", "0")->get();
        }

        return $languages;
    }

    public function findByUid($uid, $respectHidden = 0) {
        $language = DB::table("languages")->select("*")->where("uid", $uid)->get()->first();
        return $language;
    }

    public function getSessionLanguage() {

    }
}
