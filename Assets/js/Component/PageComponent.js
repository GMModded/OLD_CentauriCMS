Centauri.Component.Page = function() {
    $maincontent = $("#centauricms #content #maincontent");
    $ajaxButtons = $maincontent.find(".content .page-detail a.btn[data-ajax='true']");

    $ajaxButtons.each(function() {
        $btn = $(this);

        var pid = $maincontent.find(".content .page-detail").data("pid");

        $btn.click(function(e) {
            e.preventDefault();

            $contentelements = $maincontent.find(".content .page-detail .contentelement");
            var saved = false;

            $contentelements.each(function() {
                $contentelement = $(this);

                var uid = $contentelement.data("uid");
                $fields = $contentelement.find(".field");

                $fields.each(function() {
                    $field = $(this);

                    var value = $field.find("input").val();
                    var field = $field.find("input").attr("name");

                    if(typeof field == "string" && typeof value == "string") {
                        // AJAX-call to save every content element inside a foreach
                        Centauri.Utility.Ajax("Pagesave", {
                            _token: Centauri.token,
                            pid: pid,
                            uid: uid,
                            field: field,
                            value: value
                        }, function(data) {
                            Centauri.Utility.Loader.hide("maincontent");

                            console.log(data);

                            // if(!saved) {
                            //     saved = true;
                            //     toastr["success"]("Page saved!");
                            // }
                        });
                    }
                });
            });
        });
    });
};
