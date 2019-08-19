<?php

return [
    // Never change this value - it may cause a config-reset!
    "version" => [
        "Core" => "1.0"
    ],

    "language" => [
        "default" => "de",
        "fallback" => "de",

        "list" => [
            "de",
            "en"
        ]
    ],

    "hooks" => [
        "404" => "\\CentauriCMS\\Centauri\\Hook\\PageNotFoundHook::handle"
    ],

    "web" => [
        "requests" => [
            "urlMasks" => [
                "ignoreCamelCase" => false
            ]
        ]
    ]
];
