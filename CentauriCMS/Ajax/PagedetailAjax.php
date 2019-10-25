<?php

namespace CentauriCMS\Centauri\Ajax;

use CentauriCMS\Centauri\Helper\HookHelper;
use CentauriCMS\Centauri\Service\WizardService;

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
        $fileComponent = new \CentauriCMS\Centauri\Component\FileComponent;

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
            $hooks = $GLOBALS["Centauri"]["hooks"];

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
            
            $CFConfigHooks = $hooks["CFConfigElement"] ?? null;
            $beforeHooks = null;
            $afterHooks = null;

            if(!is_null($CFConfigHooks)) {
                $beforeHooks = $CFConfigHooks["before"];
                $afterHooks = $CFConfigHooks["after"];
            }

            foreach($colPositions as $rowCols) {
                foreach($rowCols as $colPos => $rowCol) {
                    $elementsArr = $elements->$colPos;
                    
                    foreach($elementsArr as $element) {
                        $fields = (array) $element;

                        foreach($defaultCols as $defaultCol) {
                            if(isset($fields[$defaultCol])) {
                                unset($fields[$defaultCol]);
                            }
                        }

                        foreach($fields as $field => $value) {
                            $cfg = isset($config[$field]) ? $config[$field] : null;

                            if(!is_null($cfg)) {
                                $html = $cfg["html"] ?? "";
                                $originHtml = $html;

                                $wizard = $cfg["wizard"] ?? null;

                                if(!is_null($beforeHooks)) {
                                    $wizardHook = $beforeHooks["Wizard"] ?? null;

                                    if(!is_null($wizardHook)) {
                                        $newData = HookHelper::callHook($wizardHook, [
                                            "uid" => $uid,
                                            "fields" => $fields,
                                            "field" => $field,
                                            "value" => $value,
                                            "config" => $cfg,
                                            "html" => $originHtml
                                        ]);

                                        $field = $newData["field"];
                                        $value = $newData["value"];
                                        $cfg = $newData["config"];

                                        $html = $newData["html"];
                                        if($html !== $originHtml) {
                                            $cfg["html"] = $html;
                                        }

                                        $cfg["additional"] = $newData["additional"] ?? null;
                                        $fields[$field] = $cfg;
                                    }
                                }

                                if(!is_null($wizard)) {
                                    $currentValue = $element->$field;
                                    $additionalData = [];

                                    if($wizard == "SelectWizard") {
                                        $additionalData["items"] = $cfg["items"];
                                    }

                                    $data = [
                                        "html" => $html,
                                        "currentValue" => $currentValue,
                                        "value" => $value,
                                        "field" => $field
                                    ];

                                    $wizardServiceData = WizardService::update($wizard, $data, $additionalData);
                                    $html = $wizardServiceData["html"];
                                } else {
                                    $html = str_replace("{VALUE}", $element->$field, $html);
                                }

                                $html = str_replace("{NAME}", $field, $html);
                                $html = str_replace("{UID}", $element->uid, $html);

                                $cfg["html"] = $html;
                                $fields[$field] = $cfg;
                            }

                            if(!is_null($afterHooks)) {
                                $wizardHook = $afterHooks["Wizard"] ?? null;

                                if(!is_null($wizardHook)) {
                                    $newData = HookHelper::callHook($wizardHook, [
                                        "uid" => $uid,
                                        "fields" => $fields,
                                        "field" => $field,
                                        "value" => $value,
                                        "config" => $cfg,
                                        "html" => $originHtml
                                    ]);

                                    $field = $newData["field"];
                                    $value = $newData["value"];
                                    $cfg = $newData["config"];

                                    $html = $newData["html"];
                                    if($html !== $originHtml) {
                                        $cfg["html"] = $html;
                                    }

                                    $fields[$field] = $cfg;
                                }
                            }

                            $element->fields = $fields;
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
