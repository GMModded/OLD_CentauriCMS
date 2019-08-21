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
            $cfConfig = (include __DIR__ . "/../Datasaver/CFConfig.php");
            $elements = $datasaverUtility->findByType("elements", ["page" => $page, "pid" => $pid]);

            $fieldsArray = [];

            foreach($elements as $uid => $element) {
                $fieldsArray[$uid] = [
                    "ctype" => $element["ctype"],
                    "fields" => $element["fields"]
                ];
            }

            foreach($fieldsArray as $uid => $fieldArray) {
                foreach($fieldArray["fields"] as $field => $value) {
                    $cfg = $cfConfig[$field];

                    foreach($cfg as $key => $txt) {
                        $txt = str_replace("{VALUE}", $value, $txt);
                        $txt = str_replace("{NAME}", $field, $txt);
                        $cfg[$key] = $txt;
                    }

                    $fieldsArray[$uid]["fields"][$field] = $cfg;
                }
            }

            return view("Backend.Partials.pagedetail", [
                "page" => $page,
                "fieldsArray" => $fieldsArray,

                "data" => [
                    "token" => $sessionToken
                ]
            ]);
        }
    }
}
