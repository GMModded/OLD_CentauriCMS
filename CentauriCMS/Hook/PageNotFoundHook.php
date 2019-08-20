<?php

namespace CentauriCMS\Centauri\Hook;

class PageNotFoundHook {
    public function handle() {
        echo view("Frontend.404");
    }
}
