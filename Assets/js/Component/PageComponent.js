Centauri.Component.Page = function() {
    $maincontent = $("#centauricms #content #maincontent");

    $pagedetail = $maincontent.find(".content .page-detail");
    $btn = $("a.btn[data-ajax='true']");

    var pid = $pagedetail.data("pid"),
        uid = $pagedetail.data("uid");

    $btn.click(function(e) {
        e.preventDefault();

        $btn = $(this);
        var ajaxBtnData = $btn.data("ajax-btn");
        Centauri.Component.Page.$btn = $(this);

        if(!Centauri.Component.Page.registeredAjaxs[ajaxBtnData]) {
            Centauri.Component.Page.registeredAjaxs[ajaxBtnData] = true;

            if(ajaxBtnData == "newelement")  {
                $("#newelement-btn").removeAttr("id");
                $(this).attr("id", "newelement-btn");

                Centauri.Utility.Loader.show("maincontent");

                Centauri.Utility.Ajax(Centauri.Utility.URL("get").ajax + "Pagebutton", {
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
            }

            if(ajaxBtnData == "showfrontend") {
                Centauri.Utility.Ajax(Centauri.Utility.URL("get").ajax + "Pagebutton", {
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
                Centauri.Utility.Loader.show("maincontent");
                Centauri.Utility.Loader.show("pagetree");

                // Saving page itself via AJAX call
                var title = $maincontent.find("input#pagetitle").val(),
                    urlmask = $maincontent.find("input#pageurlmasks").val(),
                    lid = $maincontent.find("input#language").parent().find("[type='hidden']").val();

                Centauri.Utility.Ajax(Centauri.Utility.URL("get").ajax + "Pagebutton", {
                    _token: Centauri.token,
                    pid: pid,
                    btn: "SAVE",
                    type: "PAGE",

                    page: {
                        lid: lid,
                        title: title,
                        urlmasks: urlmask
                    }
                }, function(data) {
                    $("body").append(data);

                    Centauri.Component.Pagetree();
                    Centauri.Utility.Loader.hide("pagetree");
                    Centauri.Utility.Loader.hide("maincontent");

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

                        if($field.find("img").length) {
                            field = $field.find("select").attr("name");
                            value = $field.find("select").val();
                        }

                        if($field.find("select").length) {
                            field = $field.find("select").attr("name");
                            value = $field.find("select").val();
                        }

                        if(typeof field == "string" && typeof value == "string") {
                            // AJAX-call to save every content element inside a foreach
                            Centauri.Utility.Ajax(Centauri.Utility.URL("get").ajax + "Pagebutton", {
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
                                if(typeof Centauri.Hooks.SaveFieldsByFieldHook == "function") {
                                    Centauri.Hooks.SaveFieldsByFieldHook({
                                        uid: uid,
                                        field: field,
                                        value: value
                                    });
                                }

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
                $btn = $("#newelement-btn");

                Centauri.Utility.Loader.show("maincontent");

                $("#pages li[data-uid='" + uid + "']").trigger("click");

                var uid = 0;
                var lid = $maincontent.find("input#language").parent().find("[type='hidden']").val();

                $contentelements = $pagedetail.find(".contentelement");
                $contentelements.each(function() {
                    var ceUid = $(this).data("uid");
                    if(ceUid > uid) uid = ceUid;
                });

                $contentelement = $("#modal-newelement .contentelement.active");
                var ctype = $contentelement.data("ctype");
                $fields = $contentelement.find(".bottom .field .content");

                var fields = [];

                $fields.each(function() {
                    $field = $(this);

                    var tempField = {};

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
                        tempField.field = field;
                        tempField.value = value;
                    }

                    fields.push(tempField);
                });

                Centauri.Utility.Ajax(Centauri.Utility.URL("get").ajax + "Pagebutton", {
                    _token: Centauri.token,
                    pid: pid,
                    lid: lid,
                    btn: "SAVE_NEW_ELEMENT",

                    fields: fields,
                    ctype: ctype
                }, function(data) {
                    $("body").append(data);
                    Centauri.Utility.Loader.hide("maincontent");

                    $("#modal-newelement").modal("hide");

                    var uid = $pagedetail.data("uid");
                    $("#pages li[data-uid='" + uid + "']").trigger("click");

                    Centauri.Component.Page.registeredAjaxs[ajaxBtnData] = false;
                });
            }
        }
    });
};

Centauri.Component.Page.win = null,
Centauri.Component.Page.winUrl = null,
Centauri.Component.Page.$btn = null;
$btn = null;

Centauri.Component.Page.registeredAjaxs = {};
