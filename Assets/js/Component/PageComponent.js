Centauri.Component.Page = function() {
    $maincontent = $("#centauricms #content #maincontent");
    $ajaxButtons = $maincontent.find(".content .page-detail a.btn[data-ajax='true']");

    $ajaxButtons.each(function() {
        $btn = $(this);

        var pid = $maincontent.find(".content .page-detail").data("pid");

        $btn.click(function(e) {
            e.preventDefault();

            $contentelements = $maincontent.find(".content .page-detail .contentelement");
            $contentelements.each(function() {
                $contentelement = $(this);

                var uid = $contentelement.data("uid");
                var value = $contentelement.find("input").attr("value");

                // AJAX-call to save every content element inside a foreach
                Centauri.Utility.Ajax("Pagesave", {
                    _token: Centauri.token,
                    pid: pid,
                    uid: uid,
                    value: value
                }, function(data) {
                    Centauri.Utility.Loader.hide("maincontent");
                });
            });
        });
    });
};
