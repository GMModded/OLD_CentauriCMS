<?php

namespace CentauriCMS\Centauri\Service;

class WizardService {
    const Centauri = \CentauriCMS\Centauri\Centauri::class;

    public static function update($wizard, $data, $additionalData = []) {
        $wizard = str_replace("Wizard", "", $wizard);

        $Centauri = self::Centauri;
        $fileComponent = $Centauri::makeInstance(\CentauriCMS\Centauri\Component\FileComponent::class);

        $val = $data["value"];
        $currentValue = $data["currentValue"];
        $html = $data["html"];
        $field = $data["field"];

        if($wizard == "Image") {
            if($currentValue != 0) {
                $uid = $currentValue;
                $file = $fileComponent->findByUid($uid);
                
                $val = $file->source;
                $html = str_replace("{VALUE}", $val, $html);
                $tempHtml = $html;
                $html = "<div class='image-cropper'>$tempHtml</div>";
            } else {
                $html = "<div class='upload-image'><button>upload image</button></div>";
            }
        }

        if($wizard == "Select") {
            $items = $additionalData["items"];
            $html = "";

            foreach($items as $key => $item) {
                $label = $items[$key][0];
                $value = $items[$key][1];

                if($currentValue == $value || $key == 0) {
                    $html .= "<option value='" . $value. "' selected>" . $label . "</option>";
                } else {
                    $html .= "<option value='" . $value . "'>" . $label . "</option>";
                }
            }

            $html = "<select name='" . $field . "'>". $html . "</select>";
        }

        $data["html"] = $html;
        return $data;
    }
}
