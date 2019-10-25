<?php

namespace CentauriCMS\Centauri\Ajax;

use CentauriCMS\Centauri\Component\FileComponent;

class ImageComponentAjax {
    public function ImageComponent() {
        $request = Request();

        $sessionToken = $request->session()->get("_token");
        $uid = $request->input("uid");

        $fileComponent = new FileComponent;
        $file = $fileComponent->findByUid($uid);

        return view("Backend.Templates.Utility.imagecomponent", [
            "image" => $file,

            "data" => [
                "_token" => $sessionToken
            ]
        ]);
    }
}
