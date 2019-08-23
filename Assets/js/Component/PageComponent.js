var win = null,
    winUrl = null;

Centauri.Component.Page = function() {
    $maincontent = $("#centauricms #content #maincontent");

    $pagedetail = $maincontent.find(".content .page-detail");
    $ajaxButtons = $pagedetail.find("a.btn[data-ajax='true']");

    var pid = $pagedetail.data("pid");

    $ajaxButtons.each(function() {
        $btn = $(this);

        $btn.click(function(e) {
            e.preventDefault();

            $btn = $(this);
            var ajaxBtnData = $btn.data("ajax-btn");
            Centauri.Utility.Loader.show("maincontent");

            if(ajaxBtnData == "showfrontend") {
                Centauri.Utility.Ajax("Pagebutton", {
                    _token: Centauri.token,
                    pid: pid,
                    btn: "SHOW_FRONTEND"
                }, function(data) {
                    Centauri.Utility.Loader.hide("maincontent");

                    if(winUrl != data) {
                        win = null;
                    }

                    if(win == null) {
                        win = window.open(data, "_blank");
                        winUrl = data;
                    }

                    win.focus();
                });
            }

            if(ajaxBtnData == "save") {
                // Saving page itself via AJAX call
                var title = $maincontent.find("input#pagetitle").val(),
                    urlmask = $maincontent.find("input#pageurlmask").val();

                Centauri.Utility.Ajax("Pagebutton", {
                    _token: Centauri.token,
                    pid: pid,
                    btn: "SAVE",
                    type: "PAGE",

                    page: {
                        title: title,
                        urlmask: urlmask
                    }
                }, function(data) {
                    Centauri.Utility.Loader.hide("maincontent");
                    $("body").append(data);
                });

                // Saving all Content Elements through a foreach
                $contentelements = $maincontent.find(".content .page-detail .contentelement");
                var elementsSaved = false;

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
                            Centauri.Utility.Ajax("Pagebutton", {
                                _token: Centauri.token,
                                pid: pid,
                                btn: "SAVE",
                                type: "CONTENT_ELEMENTS",

                                element: {
                                    uid: uid,
                                    field: field,
                                    value: value
                                }
                            }, function(data) {
                                if(!elementsSaved) {
                                    elementsSaved = true;
                                    $("body").append(data);
                                }
                            });
                        }
                    });
                });
            }

            if(ajaxBtnData == "delete") {
                Centauri.Utility.Loader.hide("maincontent");
                var a = confirm("wow.");
            }
        });
    });
};
