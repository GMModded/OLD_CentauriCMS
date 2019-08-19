<?php

use CentauriCMS\Centauri\Controller\CentauriController;

Route::get("/", function() {
    $pageComponent = new \CentauriCMS\Centauri\Component\PageComponent;
    return $pageComponent->handle("/");
});

Route::get("{nodes}", function($nodes = []) {
    $pageComponent = new \CentauriCMS\Centauri\Component\PageComponent;
    return $pageComponent->handle($nodes);
})->where(["nodes" => ".*"]);

Route::post("{nodes}", function($nodes = []) {
    $pageComponent = new \CentauriCMS\Centauri\Component\PageComponent;
    return $pageComponent->handle($nodes);
})->where(["nodes" => ".*"]);
