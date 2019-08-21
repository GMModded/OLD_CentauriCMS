<?php

namespace CentauriCMS\Centauri\Ajax;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class PagesaveAjax {
    public function Pagesave() {
        $request = Request();

        $sessionToken = $request->session()->get("_token");

        $pid = $request->input("pid");
        $uid = $request->input("uid");
        $value = $request->input("value");
        $field = $request->input("field");

        $pageComponent = new \CentauriCMS\Centauri\Component\PageComponent;
        $page = $pageComponent->findByPid($pid);
        $page = $pageComponent->getPageDatas($page, $pid);

        $datasaverUtility = new \CentauriCMS\Centauri\Utility\DatasaverUtility;
        $elements = $datasaverUtility->findByType("elements", [
            "page" => $page,
            "pid" => $pid
        ]);

        $newElements = $elements;
        $newElements[$uid]["fields"][$field] = $value;

        $pathsUtility = new \CentauriCMS\Centauri\Utility\PathsUtility;
        $uri = $pathsUtility->rootPath();

        $json = json_decode(file_get_contents($uri . "/CentauriCMS/Datasaver/json/elements.json"), true);
        $json[$pid] = array_replace($json[$pid], $newElements);

        try {
            file_put_contents(__DIR__ . "/../Datasaver/json/elements.json", json_encode($json, JSON_FORCE_OBJECT|JSON_PRETTY_PRINT));
            return "true";
        } catch(Exception $e) {
            return json_encode(["error" => "NOT_SAVED"]);
        }
    }
}
