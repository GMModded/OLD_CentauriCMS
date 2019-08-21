<?php

namespace CentauriCMS\Centauri\Component;

class RenderingComponent {
    public function renderFrontend($elements) {
        foreach($elements as $uid => $fieldArray) {
            $ctype = $fieldArray["ctype"];
            $data = $fieldArray["fields"];

            echo view("Frontend.Templates.$ctype", ["data" => $data]);
        }
    }

    public function renderBackend($elements) {
        dd($elements);
    }
}
