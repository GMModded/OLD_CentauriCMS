<?php

/**
 * CentauriFields Config
 */

return [
    "BE" => [
        "layout" => [
            "rowCols" => [
                "0" => "6",
                "1" => "12",
                "2" => "4"
            ]
        ]
    ],

    "config" => [
        "ce_header" => [
            "label" => "Header",
            "html" => "<input type='text' name='{NAME}' value='{VALUE}' class='centauri-input' />"
        ],

        "ce_subheader" => [
            "label" => "Subheader",
            "html" => "<input type='text' name='{NAME}' value='{VALUE}' class='centauri-input' />"
        ],

        "ce_description" => [
            "label" => "RTE",
            "html" => "<textarea name='{NAME}' class='centauri-textarea'>{VALUE}</textarea>"
        ],

        "ce_image" => [
            "label" => "Image",
            "wizard" => "ImageWizard",
            "html" => "<img name='{NAME}' class='img-fluid' src='{VALUE}' style='max-width: 150px;' />"
        ],

        "ce_select" => [
            "label" => "Select",
            "wizard" => "SelectWizard",
            "items" => [
                ["Name", "Value"],
                ["c", "d"]
            ]
        ]
    ],

    "palettes" => [
        "headerteaserimage" => [
            "ce_image",
            "ce_header",
            "ce_subheader",
            "ce_description"
        ],

        "textimage" => [
            "ce_image",
            "ce_header",
            "ce_subheader",
            "ce_description"
        ]
    ],

    "tabs" => [
        "general" => [
            "headerteaserimage",
            "textimage"
        ],

        "test" => [
            "textimage"
        ]
    ]
];
