<?php

namespace CentauriCMS\Centauri\Ajax;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class PagetreeAjax {
    public function Pagetree() {
        $datasaverUtility = new \CentauriCMS\Centauri\Utility\DatasaverUtility;
        $pages = $datasaverUtility->findByType("pages");

        return view("Backend.Templates.Utility.pagetree", [
            "pages" => $pages
        ]);
    }
}
