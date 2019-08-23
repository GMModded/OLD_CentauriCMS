<?php

namespace CentauriCMS\Centauri\Ajax;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class PagebuttonAjax {
    public function Pagebutton() {
        $request = Request();

        $sessionToken = $request->session()->get("_token");
        $pid = $request->input("pid");

        $pageComponent = new \CentauriCMS\Centauri\Component\PageComponent;
        $page = $pageComponent->findByPid($pid);
        $pageDatasArr = $pageComponent->getPageDatas($page, $pid);

        $datasaverUtility = new \CentauriCMS\Centauri\Utility\DatasaverUtility;

        $btn = $request->input("btn");
        $type = $request->input("type");

        if($btn == "SHOW_FRONTEND") {
            return $pageDatasArr["publicUrl"];
        }

        if($btn == "SAVE") {
            $pageSaved = false;
            $elementsSaved = false;

            // Conditions which save-type has been requested
            if($type == "PAGE") {
                // Page datas
                $pageDatas = $request->input("page");
                $pageSaved = $this->savePage($page, $pid, $pageDatas);
            }

            if($type == "CONTENT_ELEMENTS") {
                // Content Element datas
                $elementDatas = $request->input("element");
                $uid = $elementDatas["uid"];
                $value = $elementDatas["value"];
                $field = $elementDatas["field"];

                $elements = $datasaverUtility->findByType("elements", [
                    "page" => $page,
                    "pid" => $pid
                ]);

                // Saving all content elements inside of elements.json
                $elementsSaved = $this->saveElements($pid, $uid, $field, $value, $elements);
            }

            $toastUtility = new \CentauriCMS\Centauri\Utility\ToastUtility;

            if($pageSaved) {
                return $toastUtility->render("Saved", "Page has been saved");
            } else if($elementsSaved) {
                return $toastUtility->render("Saved", "Elements has been saved");
            } else {
                return $toastUtility->render("Error", "Something went wrong while saving!", "error");
            }
        }

        if($btn == "DELETE") {

        }
    }

    /**
     * Core function for saving page datas
     */
    public function savePage($page, $pid, $pageDatas) {
        $page["name"] = $pageDatas["title"];

        $urlmask = "";
        if(strpos($pageDatas["urlmask"], ",") !== false) {
            $urlmask = explode(",", $pageDatas["urlmask"]);

            foreach($urlmask as $key => $value) {
                $urlmask[$key] = trim($value);
            }
        } else {
            $urlmask = $pageDatas["urlmask"];
        }
        $page["urlmask"] = $urlmask;

        $pathsUtility = new \CentauriCMS\Centauri\Utility\PathsUtility;
        $uri = $pathsUtility->rootPath();

        $json = json_decode(file_get_contents($uri . "/CentauriCMS/Datasaver/json/pages.json"), true);
        $json[$pid] = array_replace($json[$pid], $page);

        try {
            file_put_contents(__DIR__ . "/../Datasaver/json/pages.json", json_encode($json, JSON_PRETTY_PRINT));
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    /**
     * Core function for saving content elements
     */
    public function saveElements($pid, $uid, $field, $value, $elements) {
        $newElements = $elements;
        $newElements[$uid]["fields"][$field] = $value;

        $pathsUtility = new \CentauriCMS\Centauri\Utility\PathsUtility;
        $uri = $pathsUtility->rootPath();

        $json = json_decode(file_get_contents($uri . "/CentauriCMS/Datasaver/json/elements.json"), true);
        $json[$pid] = array_replace($json[$pid], $newElements);

        try {
            file_put_contents(__DIR__ . "/../Datasaver/json/elements.json", json_encode($json, JSON_FORCE_OBJECT|JSON_PRETTY_PRINT));
            return true;
        } catch(Exception $e) {
            return false;
        }
    }
}
