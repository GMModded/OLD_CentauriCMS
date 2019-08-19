<?php

namespace CentauriCMS\Centauri\Ajax;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class PagedetailAjax {
    public function Pagedetail() {
        $request = Request();

        $sessionToken = $request->session()->get("_token");
        $uid = $request->input("uid");
        $crtModule = $request->input("crtModule");

        $datasaverUtility = new \CentauriCMS\Centauri\Utility\DatasaverUtility;
        $pages = $datasaverUtility->findByType("pages");

        $pageComponent = new \CentauriCMS\Centauri\Component\PageComponent;
        $page = $pageComponent->findByUid($uid);

        if($crtModule == "home") {
            $page = $pageComponent->getPageDatas($page);
            return view("Backend.Partials.home", [
                "page" => $page,

                "data" => [
                    "token" => $sessionToken
                ]
            ]);
        }

        if($crtModule == "pages") {
            $elements = $datasaverUtility->findByType("elements", ["page" => $page, "uid" => $uid]);
            $elementsConfig = (include __DIR__ . "/../Datasaver/elementsConfig.php");

            foreach($elements as $element) {
                $data = $element["data"];

                foreach($data as $key => $value) {
                    $cfg = $elementsConfig[$key];
                    $html = $cfg["html"];

                    $html = str_replace("{VALUE}", $value, $html);

                    $cfg["html"] = $html;
                    $elementsConfig[$key] = $cfg;
                }
            }

            return view("Backend.Partials.pagedetail", [
                "page" => $page,
                "elements" => $elements,
                "elementsConfig" => $elementsConfig,

                "data" => [
                    "token" => $sessionToken
                ]
            ]);
        }
    }
}
