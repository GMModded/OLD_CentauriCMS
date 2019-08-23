<?php

namespace CentauriCMS\Centauri\Utility;

class ToastUtility {
    /**
     * Toasts for laravel blade (templates)
     * 
     * @param boolean $respectOnload
     * @param string $title
     * @param string $description
     * @param string $toastclass
     * 
     * @return void
     */
    public static function show($respectOnload = false, $title = "", $description = "", $toastclass = "success") {
        if($respectOnload) {
            echo "<script id='toast-script'>
                window.onload = function() {
                    toastr['" . $toastclass . "']('" . $title . "', '" . $description . "');
                };
            </script>";

        } else {
            echo "<script id='toast-script'>
                toastr['" . $toastclass . "']('" . $title . "', '" . $description . "');
            </script>";
        }
    }

    public function render($title, $description = "", $toastclass = "success") {
        return "<script id='toast-script'>
                    toastr['" . $toastclass . "']('" . $title . "', '" . $description . "');
                </script>";
    }
}
