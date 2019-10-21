<?php

namespace CentauriCMS\Centauri\Ajax;

use Illuminate\Support\Facades\DB;

class PagetreeAjax {
    public function Pagetree() {
        $pages = DB::table("pages")->select("*")->get("items");

        return view("Backend.Templates.Utility.pagetree", [
            "pages" => $pages
        ]);
    }
}
