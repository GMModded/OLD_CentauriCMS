<?php

namespace CentauriCMS\Centauri\Component;

class RenderingComponent {
    public function renderFrontend($elements) {
        foreach($elements as $uid => $elementArray) {
            $fields = $elementArray["fields"];
            $ctype = $elementArray["ctype"];

            echo view("Frontend.Templates.$ctype", ["data" => $fields]);
        }
    }

    public function renderBackend($elements) {
        dd($elements);
    }
}
