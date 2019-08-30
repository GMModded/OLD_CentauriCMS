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

        if($btn == "NEW_ELEMENT") {
            $cfConfig = (include __DIR__ . "/../Datasaver/CFConfig.php");

            $config = $cfConfig["config"];
            $cfConfigPalettes = $cfConfig["palettes"];

            $datasaverUtility = new \CentauriCMS\Centauri\Utility\DatasaverUtility;
            $elements = $datasaverUtility->findByType("elements", [
                "page" => $page,
                "pid" => $pid
            ]);

            foreach($elements as $uid => $element) {
                foreach($element["fields"] as $ctype => $value) {
                    $palettesFields = $cfConfigPalettes[$element["ctype"]];

                    foreach($palettesFields as $key => $ctypeField) {
                        if($palettesFields[$key] == $ctypeField && isset($element["fields"][$ctypeField])) {
                            $cfg = $config[$ctypeField];

                            foreach($cfg as $cfgKey => $cfgVal) {
                                if($cfgKey == "html") {
                                    $html = $cfg["html"];

                                    $value = $element["fields"][$ctypeField];
                                    $name = $ctypeField;

                                    $html = str_replace("{NAME}", $name, $html);
                                    $html = str_replace("{VALUE}", "", $html);

                                    $palettesFields[$ctypeField][$cfgKey] = $html;
                                } else {
                                    $palettesFields[$ctypeField][$cfgKey] = $cfgVal;
                                }
                            }
                        }

                        unset($palettesFields[$key]);
                    }
                }

                $cfConfigPalettes[$element["ctype"]] = $palettesFields;
                $cfConfigPalettes[$element["ctype"]]["uid"] = (int) $uid;
            }

            $tabs = $cfConfig["tabs"];

            foreach($tabs as $tab => $palettes) {
                foreach($palettes as $key => $palette) {
                    unset($tabs[$tab][$key]);
                    $tabs[$tab][$palette] = $cfConfigPalettes[$palette];
                }
            }

            return view("Backend.Templates.Utility.newelement", [
                "page" => $page,
                "tabs" => $tabs,

                "data" => [
                    "token" => $sessionToken
                ]
            ]);
        }

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

                // Only saving when $field & $value ain't null
                if(!is_null($field) && !is_null($value)) {
                    // Saving all content elements inside of elements.json
                    $elementsSaved = $this->saveElements($pid, $uid, $field, $value, $elements);
                }
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

        if($btn == "SAVE_NEW_ELEMENT") {
            dd("hi");
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
