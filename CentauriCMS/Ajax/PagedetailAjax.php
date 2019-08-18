<?php

namespace CentauriCMS\Centauri\Ajax;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class PagedetailAjax {
    public function Pagedetail() {
        $request = Request();
        $uid = $request->input("uid");

        $datasaverUtility = new \CentauriCMS\Centauri\Utility\DatasaverUtility;
        $pages = $datasaverUtility->findByType("pages");

        $pageComponent = new \CentauriCMS\Centauri\Component\PageComponent;
        $page = $pageComponent->findByUid($uid);

        return view("Backend.Partials.pagedetail", [
            "page" => $page
        ]);
    }
}
