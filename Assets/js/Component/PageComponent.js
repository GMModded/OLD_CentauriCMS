Centauri.Component.Page = function() {
    $maincontent = $("#centauricms #content #maincontent");

    $pagedetail = $maincontent.find(".content .page-detail");
    $btn = $("a.btn[data-ajax='true']");

    var pid = $pagedetail.data("pid");

    $btn.click(function(e) {
        e.preventDefault();

        $btn = $(this);

        var ajaxBtnData = $btn.data("ajax-btn");

        if(!Centauri.Component.Page.registeredAjaxs[ajaxBtnData]) {
            Centauri.Component.Page.registeredAjaxs[ajaxBtnData] = true;

            if(ajaxBtnData == "newelement")  {
                Centauri.Component.Page.$btn = $btn;

                if(!$("html").hasClass("modal-newelement")) {
                    Centauri.Utility.Loader.show("maincontent");

                    $("html").addClass("modal-newelement");

                    Centauri.Utility.Ajax("Pagebutton", {
                        _token: Centauri.token,
                        pid: pid,
                        btn: "NEW_ELEMENT"
                    }, function(data) {
                        Centauri.Utility.Loader.hide("maincontent");
                        $("body").append(data);

                        Centauri.Component.RTE();
                        Centauri.Wizard.NewElement();

                        Centauri.Component.Page.registeredAjaxs[ajaxBtnData] = false;
                    });
                } else {
                    $("#modal-newelement").modal("show");
                    Centauri.Component.Page.registeredAjaxs[ajaxBtnData] = false;
                }
            }

            if(ajaxBtnData == "showfrontend") {
                Centauri.Utility.Ajax("Pagebutton", {
                    _token: Centauri.token,
                    pid: pid,
                    btn: "SHOW_FRONTEND"
                }, function(data) {
                    Centauri.Utility.Loader.hide("maincontent");
    
                    if(Centauri.Component.Page.winUrl != data) {
                        Centauri.Component.Page.win = null;
                    }
    
                    if(Centauri.Component.Page.win == null) {
                        Centauri.Component.Page.win = window.open(data, "_blank");
                        Centauri.Component.Page.winUrl = data;
                    }
    
                    Centauri.Component.Page.win.focus();
                    Centauri.Component.Page.registeredAjaxs[ajaxBtnData] = false;
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

                    Centauri.Component.Page.registeredAjaxs[ajaxBtnData] = false;
                });

                // Saving all Content Elements through a foreach
                $contentelements = $pagedetail.find(".contentelement");
                var elementsSaved = false;

                $contentelements.each(function() {
                    $contentelement = $(this);

                    var uid = $contentelement.data("uid");
                    $fields = $contentelement.find(".field");

                    $fields.each(function() {
                        $field = $(this);

                        var value = "";
                        var field = "";

                        if($field.find("input").length) {
                            field = $field.find("input").attr("name");
                            value = $field.find("input").val();
                        }

                        if($field.find("textarea").length) {
                            field = $field.find("textarea").attr("name");
                            value = $field.find(".ck-content").html();
                        }

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
                Centauri.Component.Page.registeredAjaxs[ajaxBtnData] = false;
            }

            if(ajaxBtnData == "savenewelement") {
                Centauri.Utility.Loader.show("maincontent");

                $("#pages li[data-pid='" + pid + "']").trigger("click");

                var uid = 0;
                $contentelements = $pagedetail.find(".contentelement");

                $contentelements.each(function() {
                    var ceUid = $(this).data("uid");
                    if(ceUid > uid) uid = ceUid;
                });

                $("#modal-newelement").modal("hide");
                $("#modal-newelement").modal("dispose");

                Centauri.Utility.Ajax("Pagebutton", {
                    _token: Centauri.token,
                    pid: pid,
                    uid: uid,
                    btn: "SAVE_NEW_ELEMENT"
                }, function(data) {
                    $("body").append(data);
                    Centauri.Utility.Loader.hide("maincontent");

                    $("html").removeClass("modal-newelement");
                    $("#modal-newelement").remove();

                    Centauri.Component.Page.registeredAjaxs[ajaxBtnData] = false;
                });
            }
        }
    });
};

Centauri.Component.Page.win = null,
Centauri.Component.Page.winUrl = null,
Centauri.Component.Page.$btn = null;

Centauri.Component.Page.registeredAjaxs = {};
