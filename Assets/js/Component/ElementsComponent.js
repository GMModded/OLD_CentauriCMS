Centauri.Component.Elements = function() {
    $maincontent = $("#centauricms #content #maincontent");
    $contentelements = $maincontent.find(".content .page-detail .contentelement");

    $contentelements.each(function() {
        $btn = $(this).find("button.toggle-edit");

        $btn.click(function() {
            $btn = $(this);

            $btn.addClass("disabled");
            $btn.toggleClass("btn-info btn-primary");
            $btn.find("i").toggleClass("fa-eye fa-eye-slash");

            $element = $(this).parent().parent().parent();
            $element.find(".bottom").slideToggle(function() {
                $btn.removeClass("disabled");
            });
        });
    });
};
