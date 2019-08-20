<?php

namespace CentauriCMS\Centauri\Ajax;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class PagesaveAjax {
    public function Pagesave() {
        $request = Request();

        $sessionToken = $request->session()->get("_token");
        $pid = $request->input("pid");
        $value = $request->input("value");

        dd($value);
    }
}
