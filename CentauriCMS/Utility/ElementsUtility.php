<?php

namespace CentauriCMS\Centauri\Utility;

class ElementsUtility {
    /**
     * Returns elements (CTypes / Palettes) which includes the fields (ce_*)
     * which is mainly used for the backend when creating new element (modal-newelement)
     * or for rendering the backend its content elements
     * 
     * @param boolean $replaceValueWithData
     * @param array $page
     * @param string|int $pid
     * 
     * @return void
     */
    public function findAll($replaceValueWithData = true, $page, $pid) {
        $cfConfig = (include __DIR__ . "/../Datasaver/CFConfig.php");
        $config = $cfConfig["config"];
        $palettes = $cfConfig["palettes"];

        $datasaverUtility = new \CentauriCMS\Centauri\Utility\DatasaverUtility;
        $elements = $datasaverUtility->findByType("elements", [
            "page" => $page,
            "pid" => $pid
        ]);

        foreach($elements as $uid => $element) {
            foreach($element["fields"] as $ctype => $value) {
                $palettesFields = $palettes[$element["ctype"]];

                foreach($palettesFields as $key => $ctypeField) {
                    if($palettesFields[$key] == $ctypeField && isset($element["fields"][$ctypeField])) {
                        $cfg = $config[$ctypeField];

                        foreach($cfg as $cfgKey => $cfgVal) {
                            if($cfgKey == "html") {
                                $html = $cfg["html"];

                                $value = $element["fields"][$ctypeField];
                                $name = $ctypeField;

                                $html = str_replace("{NAME}", $name, $html);

                                if($replaceValueWithData) $html = str_replace("{VALUE}", $value, $html);
                                else $html = str_replace("{VALUE}", "", $html);

                                $palettesFields[$ctypeField][$cfgKey] = $html;
                            } else {
                                $palettesFields[$ctypeField][$cfgKey] = $cfgVal;
                            }
                        }
                    }

                    unset($palettesFields[$key]);
                }
            }

            $palettes[$element["ctype"]] = $palettesFields;
            $palettes[$element["ctype"]]["uid"] = $uid;
        }

        return $palettes;
    }
}
