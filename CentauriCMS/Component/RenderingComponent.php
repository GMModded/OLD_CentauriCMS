<?php

namespace CentauriCMS\Centauri\Component;

class RenderingComponent {
    public function renderFrontend($page, $elements, $config) {
        $languageComponent = new \CentauriCMS\Centauri\Component\LanguageComponent;
        $languages = $languageComponent->findAll();

        echo view("Frontend.Default", [
            "page" => $page,

            "language" => $config["language"] ?? "de",
            "languages" => $languages
        ]);

        foreach($elements as $element) {
            echo view("Frontend.Templates." . $element->CType, [
                "data" => $element
            ]);
        }
    }

    public function renderBackend($elements) {
        dd($elements);
    }
}
