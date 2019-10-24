<?php

namespace CentauriCMS\Centauri\Hook;

class CFConfigWizardHook {
    public function fieldChanger($data) {
        $field = $data["field"];

        if($field == "ce_header") {
            $html = $data["html"];

            $data["value"] = "TEST XD";

            $html = str_replace("{NAME}", $data["field"], $html);
            $html = str_replace("{VALUE}", $data["value"], $html);

            $data["html"] = $html;
        }

        return $data;
    }
}
