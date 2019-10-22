<?php

namespace CentauriCMS\Centauri\Ajax;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class PageAjax {
    public function Page() {
        $request = Request();

        $sessionToken = $request->session()->get("_token");
        $pid = $request->input("pid");

        $pageComponent = new \CentauriCMS\Centauri\Component\PageComponent;
        $page = $pageComponent->findByPid($pid);
        $pageDatasArr = $pageComponent->getPageDatas($page, $pid);

        $datasaverUtility = new \CentauriCMS\Centauri\Utility\DatasaverUtility;
        $toastUtility = new \CentauriCMS\Centauri\Utility\ToastUtility;

        $type = $request->input("type");

        if($type == "DELETE_ELEMENT") {
            $uid = $request->input("uid");

            $elements = $datasaverUtility->findByType("elements", [
                "page" => $page,
                "pid" => $pid
            ]);

            $elementRemoved = $this->removeElement($pid, $uid, $elements);
            if($elementRemoved) {
                return $toastUtility->render("Removed", "Element has been deleted");
            } else {
                return $toastUtility->render("Error", "Something went wrong while deleting!", "error");
            }
        }
    }

    public function removeElement($pid, $uid, $elements) {
        unset($elements[$uid]);

        foreach($elements as $key => $element) {
            unset($elements[$key]);

            if($key > 0) {
                $key = $key - 1;
            }

            $elements[$key] = $element;
        }

        $pathsUtility = new \CentauriCMS\Centauri\Utility\PathsUtility;
        $uri = $pathsUtility->rootPath();

        $json = json_decode(file_get_contents($uri . "/CentauriCMS/Datasaver/json/elements.json"), true);
        $json[$pid] = $elements;

        try {
            file_put_contents(__DIR__ . "/../Datasaver/json/elements.json", json_encode($json, JSON_FORCE_OBJECT|JSON_PRETTY_PRINT));
            return true;
        } catch(Exception $e) {
            return false;
        }
    }
}
