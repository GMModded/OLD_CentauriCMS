<?php

return [
    // Never change this value - it may cause a config-reset!
    "version" => [
        "Core" => "1.0"
    ],

    "language" => "de",

    "hooks" => [
        "404" => "\\CentauriCMS\\Centauri\\Hook\\PageNotFoundHook::handle",

        "CFConfigElement" => [
            "before" => [
                // "Wizard" => "\\CentauriCMS\\Centauri\\Hook\\CFConfigWizardHook::fieldChanger"
            ],
            "after" => [
                // "Wizard" => "\\CentauriCMS\\Centauri\\Hook\\CFConfigWizardHook::fieldChanger"
            ]
        ]
    ]
];
