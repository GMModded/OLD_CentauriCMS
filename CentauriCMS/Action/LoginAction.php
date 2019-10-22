<?php

namespace CentauriCMS\Centauri\Action;

use Illuminate\Support\Facades\Session;

class LoginAction {
    public static function login($request) {
        $config = \CentauriCMS\Centauri\Utility\ConfigUtility::get();
        // $fallbackLanguage = $config["language"]["fallback"];

        $token = $request->input("_token");

        $username = $request->input("username");
        $password = $request->input("password");

        $lid = $request->input("language");
        $languagelabel = $request->input("languagelabel");

        $languageComponent = new \CentauriCMS\Centauri\Component\LanguageComponent;
        $language = $languageComponent->findByUid($lid);

        $user = \Illuminate\Support\Facades\DB::table("be_users")->select("*")->where([
            "username" => $username,
            "password" => md5($password)
        ])->get()->first();

        if($user) {
            Session::put("LOGGED_IN", true);
            Session::put("username", $username);
            Session::put("password", $password);
            Session::put("languageid", $lid);

            return redirect("/centauri/" . $language->shortcut)->with([
                "LOGIN_STATE" => "200"
            ]);
        } else {
            return redirect("/centauri")->with("LOGIN_STATE", "404");
        }
    }
}
