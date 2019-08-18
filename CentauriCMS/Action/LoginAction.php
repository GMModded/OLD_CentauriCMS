<?php

namespace CentauriCMS\Centauri\Action;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LoginAction {
    public static function login($request) {
        $config = \CentauriCMS\Centauri\Utility\ConfigUtility::get();
        $fallbackLanguage = $config["language"]["fallback"];

        $token = $request->input("_token");

        $username = $request->input("username");
        $password = $request->input("password");
        $language = $request->input("language") ?? $fallbackLanguage;

        if($username == "admin" && $password == "password") {
            Session::put("LOGGED_IN", true);
            Session::put("username", $username);
            Session::put("password", $password);
            Session::put("language", $language);

            return redirect("/centauri/$language")->with([
                "LOGIN_STATE" => "200"
            ]);
        } else {
            return redirect("/centauri")->with("LOGIN_STATE", "404");
        }
    }
}
