<?php

namespace CentauriCMS\Centauri\Ajax;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class PagedetailAjax {
    public function Pagedetail() {
        $request = Request();

        $sessionToken = $request->session()->get("_token");
        $pid = $request->input("pid");
        $crtModule = $request->input("crtModule");

        $datasaverUtility = new \CentauriCMS\Centauri\Utility\DatasaverUtility;
        $pages = $datasaverUtility->findByType("pages");

        $pageComponent = new \CentauriCMS\Centauri\Component\PageComponent;
        $page = $pageComponent->findByPid($pid);
        $page = $pageComponent->getPageDatas($page, $pid);

        if($crtModule == "home") {
            return view("Backend.Partials.home", [
                "page" => $page,

                "data" => [
                    "token" => $sessionToken
                ]
            ]);
        }

        if($crtModule == "pages") {
            $elementsUtility = new \CentauriCMS\Centauri\Utility\ElementsUtility;
            $palettes = $elementsUtility->findAll(true, $page, $pid);

            return view("Backend.Partials.pagedetail", [
                "page" => $page,
                "palettes" => $palettes,

                "data" => [
                    "token" => $sessionToken
                ]
            ]);
        }
    }
}
