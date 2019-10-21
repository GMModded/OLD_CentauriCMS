Centauri.Component.Elements = function() {
    $maincontent = $("#centauricms #content #maincontent");
    $contentelements = $maincontent.find(".content .page-detail .contentelement");

    // Initializing RTE's
    Centauri.Component.RTE();

    // Initializing PageDetailComponent
    Centauri.Component.PageDetail();

    $contentelements.each(function() {
        $btn = $(this).find("button");

        $btn.click(function() {
            $btn = $(this);
            $contentelement = $btn.parent().parent().parent();

            var uid = $contentelement.data("uid");
            var toggle = $btn.data("toggle");

            if(toggle == "edit") {
                $btn.addClass("disabled");
                $btn.toggleClass("btn-info btn-primary");

                $contentelement.find(".bottom").slideToggle(function() {
                    $btn.removeClass("disabled");
                });
            }

            if(toggle == "hidden") {
                $btn.find("i").toggleClass("fa-eye fa-eye-slash");

                Centauri.Utility.Ajax(Centauri.Utility.URL("get").ajax + "Pagebutton", {
                    _token: Centauri.token,
                    uid: uid,
                    btn: "TOGGLE_HIDDEN"
                }, function(data) {
                    $("body").append(data);
                });
            }

            if(toggle == "delete") {
                if(confirm("sure?")) {
                    Centauri.Utility.Ajax(Centauri.Utility.URL("get").ajax + "Pagebutton", {
                        _token: Centauri.token,
                        uid: uid,
                        btn: "DELETE_ELEMENT"
                    }, function(data) {
                        $contentelement.slideUp(function() {
                            $contentelement.prev().remove();
                            $contentelement.remove();
                        });

                        $("body").append(data);
                    });
                }
            }
        });
    });
};
