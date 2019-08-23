<?php

/**
 * CentauriFields Config
 */

return [
    "ce_header" => [
        "label" => "Header",
        "html" => "<input type='text' name='{NAME}' value='{VALUE}' class='centauri-input' />"
    ],

    "ce_subheader" => [
        "label" => "Subheader",
        "html" => "<input type='text' name='{NAME}' value='{VALUE}' class='centauri-input' />"
    ],

    "ce_image" => [
        "label" => "Image",
        "wizard" => "ImageWizard",
        "html" => "<img style='max-width: 150px;' class='img-fluid' src='{VALUE}' />"
    ]
];
