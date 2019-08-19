<?php

namespace CentauriCMS\Centauri\Component;

class RenderingComponent {
    public function renderFrontend($elements) {
        foreach($elements as $uid => $element) {
            $element["uid"] = $uid;

            $ctype = $element["ctype"];
            $data = $element["data"];

            echo view("Frontend.Templates.$ctype", ["data" => $data]);
        }
    }

    public function renderBackend($elements) {
        dd($elements);
    }
}
