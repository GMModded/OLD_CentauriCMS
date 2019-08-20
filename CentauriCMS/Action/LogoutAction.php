<?php

namespace CentauriCMS\Centauri\Action;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LogoutAction {
    public static function logout($request) {
        $token = $request->input("_token");

        Session::flush();
        $request->session()->flush();

        return redirect("/centauri");
    }
}
