<?php

/**
 * CentauriFields Config
 */

return [
    "BE" => [
        "layout" => [
            "rowCols" => [
                // colPos => col-width
                [
                    "0" => "4",
                    "1" => "4"
                ]
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
            "wizard" => "ImageWizard",
            "label" => "Image",
            "html" => "<img name='{NAME}' class='img-fluid' src='{VALUE}' style='max-width: 150px;' />"
        ],

        "ce_select" => [
            "wizard" => "SelectWizard",
            "label" => "Select",
            "items" => [
                ["Name", "Value"],
                ["c", "d"]
            ]
        ]
    ],

    "palettes" => [
        "headerteaserimage" => [
            "ce_select",
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
