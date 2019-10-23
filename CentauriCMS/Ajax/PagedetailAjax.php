<?php

namespace CentauriCMS\Centauri\Ajax;

class PagedetailAjax {
    public function Pagedetail() {
        $request = Request();

        $sessionToken = $request->session()->get("_token");
        $sessionLanguage = $request->session()->get("languageid");

        $uid = $request->input("uid");
        $crtModule = $request->input("crtModule");

        $pageComponent = new \CentauriCMS\Centauri\Component\PageComponent;
        $elementComponent = new \CentauriCMS\Centauri\Component\ElementComponent;
        $languageComponent = new \CentauriCMS\Centauri\Component\LanguageComponent;

        $page = $pageComponent->findByUid($uid);
        $elements = $elementComponent->findByPid($page->pid);

        $languages = $languageComponent->findAll();
        $language = $languageComponent->findByUid($sessionLanguage);

        if($crtModule == "home") {
            return view("Backend.Partials.home", [
                "page" => $page,

                "data" => [
                    "token" => $sessionToken
                ]
            ]);
        }

        if($crtModule == "pages") {
            $CFConfig = (include __DIR__ . "/../Datasaver/CFConfig.php");

            $config = $CFConfig["config"];

            $backendLayout = $CFConfig["BE"]["layout"];
            $colPositions = $backendLayout["rowCols"];

            $elements = collect();

            foreach($colPositions as $rowCols) {
                foreach($rowCols as $colPos => $rowCol) {
                    $elements->$colPos = $elementComponent->findBy(
                        $page->pid,
                        $colPos
                    );
                }
            }

            $lid = $request->input("lid");

            if(!is_null($lid)) {
                $language = $languageComponent->findByUid($lid);
                $elements = $elementComponent->findByPidLid($page->pid, $lid);

                $request->session()->put("languageid", $lid);
            }

            $defaultCols = $elementComponent->defaultTableColumns;

            foreach($colPositions as $rowCols) {
                foreach($rowCols as $colPos => $rowCol) {
                    $elementsArr = $elements->$colPos;
                    
                    foreach($elementsArr as $element) {
                        $data = (array) $element;

                        foreach($defaultCols as $defaultCol) {
                            if(isset($data->$defaultCol)) {
                                unset($data->$defaultCol);
                            }
                        }

                        foreach($data as $field => $value) {
                            $cfg = $config[$field] ?? null;

                            if(!is_null($cfg)) {
                                $html = $cfg["html"] ?? "";
                                $wizard = $cfg["wizard"] ?? null;

                                if($wizard == "SelectWizard") {
                                    $items = $cfg["items"];
                                    $html = "";

                                    foreach($items as $key => $item) {
                                        $label = $items[$key][0];
                                        $value = $items[$key][1];

                                        if($key == 0) {
                                            $html .= "<option value='" . $value. "' selected>" . $label . "</option>";
                                        } else {
                                            $html .= "<option value='" . $value . "'>" . $label . "</option>";
                                        }
                                    }

                                    $html = "<select>". $html . "</select>";
                                }

                                $html = str_replace("{NAME}", $field, $html);
                                $html = str_replace("{VALUE}", $html, $html);

                                $cfg["html"] = $html;

                                $element->fields = [$field => $cfg];
                            }
                        }
                    }
                }
            }

            return view("Backend.Partials.pagedetail", [
                "backendLayout" => $backendLayout,

                "page" => $page,
                "elements" => $elements,

                "languages" => $languages,
                "language" => $language,

                "data" => [
                    "token" => $sessionToken
                ]
            ]);
        }
    }
}
