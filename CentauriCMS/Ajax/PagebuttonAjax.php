<?php

namespace CentauriCMS\Centauri\Ajax;

use \Illuminate\Support\Facades\DB;

class PagebuttonAjax {
    public function Pagebutton() {
        $request = Request();

        $sessionToken = $request->session()->get("_token");
        $uid = $request->input("uid");
        $pid = $request->input("pid");

        $pageComponent = new \CentauriCMS\Centauri\Component\PageComponent;
        $elementComponent = new \CentauriCMS\Centauri\Component\ElementComponent;

        $page = $pageComponent->findByPid($pid);

        $toastUtility = new \CentauriCMS\Centauri\Utility\ToastUtility;

        $btn = $request->input("btn");
        $type = $request->input("type");

        if($btn == "NEW_ELEMENT") {
            $cfConfig = (include __DIR__ . "/../Datasaver/CFConfig.php");

            dd($request->all());

            $config = $cfConfig["config"];
            $palettes = $cfConfig["palettes"];
            $tabs = $cfConfig["tabs"];

            $nPalettes = [];
            $nTabs = [];

            foreach($palettes as $CType => $palette) {
                foreach($palette as $key => $field) {
                    $cfg = $config[$field];

                    $html = $cfg["html"] ?? "";

                    $html = str_replace("{NAME}", $field, $html);
                    $html = str_replace("{VALUE}", "", $html);

                    $cfg["html"] = $html;
                    $nPalettes[$CType]["configs"][$field] = $cfg;
                }
            }

            foreach($tabs as $tab => $palettes) {
                foreach($palettes as $key => $palette) {
                    $nTabs[$tab][$palette] = $nPalettes[$palette];
                }
            }

            return view("Backend.Templates.Utility.newelement", [
                "page" => $page,
                "tabs" => $nTabs,

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
                $pageDatas = $request->input("page");
                $pageSaved = $this->savePage($page, $pageDatas);
            }
            if($type == "CONTENT_ELEMENTS") {
                $elementDatas = $request->input("element");

                $uid = $elementDatas["uid"];
                $value = $elementDatas["value"];
                $field = $elementDatas["field"];

                // Only saving when $field & $value ain't null
                if(!is_null($field) && !is_null($value)) {
                    $elementsSaved = $this->saveElements($pid, $uid, $field, $value);
                }
            }

            if($pageSaved) {
                return $toastUtility->render("Saved", "Page has been saved");
            } else if($elementsSaved) {
                return $toastUtility->render("Saved", "Elements has been saved");
            } else {
                // return $toastUtility->render("Error", "Something went wrong while saving!", "error");
            }
        }

        if($btn == "DELETE_PAGE") {
            dd("NOOOO");
        }

        if($btn == "TOGGLE_HIDDEN") {
            $toastText = "hidden";
            $element = $elementComponent->findByUid($uid);

            if($element->hidden) {
                $element->hidden = false;
                $toastText = "visible";
            } else {
                $element->hidden = true;
            }

            $elementComponent->saveElementByElement($element);
            return $toastUtility->render("Saved", "Element is now $toastText");
        }

        if($btn == "DELETE_ELEMENT") {
            $elementComponent->removeByUid($uid);
            return $toastUtility->render("Deleted", "Element has been deleted");
        }

        if($btn == "SAVE_NEW_ELEMENT") {
            $elements = $elementComponent->findByPid($pid);

            $pid = $request->input("pid");
            $lid = $request->input("lid");

            $GETfields = $request->input("fields");
            $CType = $request->input("ctype");

            $dbColumns = DB::getSchemaBuilder()->getColumnListing("elements");

            $fields = [
                "pid" => $pid,
                "lid" => $lid,
                "CType" => $CType,
                "hidden" => 0,
                "colPos" => 0
            ];

            foreach($GETfields as $item) {
                $field = $item["field"];
                $value = $item["value"];

                if(!is_null($field) && !is_null($value)) {
                    $fields[$field] = $value;
                }
            }

            $ignoredColumns = [
                "uid"
            ];

            foreach($dbColumns as $key => $column) {
                if(!isset($fields[$column]) && !in_array($column, $ignoredColumns)) {
                    $fields[$column] = 0;
                }
            }

            DB::table("elements")->insert($fields);
            return $toastUtility->render("Saved", "Element has been created");
        }
    }

    /**
     * Core function for saving page fields
     */
    public function savePage($page, $pageDatas) {
        foreach($pageDatas as $field => $value) {
            DB::table("pages")
                ->where([
                    "pid" => $page->pid
                ])
                ->update([
                    $field => $value
                ]);
        }

        return true;
    }

    /**
     * Core function for saving content elements
     * 
     * @param int $pid Page ID
     * @param int $uid Element ID
     * @param string $field CType
     * @param string $value New value of the element
     * @param array $elements Elements getted using ElementComponent findByUid/-Pid
     * 
     * @return void
     */
    public function saveElements($pid, $uid, $field, $value) {
        DB::table("elements")
            ->where([
                "uid" => $uid,
                "pid" => $pid
            ])
            ->update([
                $field => $value
            ]);

        return true;
    }
}
