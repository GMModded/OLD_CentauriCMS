Centauri.Component.ImageCropper = function() {
    $contentelements = $("#centauricms #content #maincontent .content .page-detail .contentelement");

    $contentelements.each(function() {
        $ce = $(this);

        $ce.find("img").on("dblclick", this, function() {
            alert($(this).attr("name"));
        });
    });
};
