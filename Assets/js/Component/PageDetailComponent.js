Centauri.Component.PageDetail = function() {
    Centauri.Elements.Dropdown(function(data) {
        if(data.id == "language") {
            console.log(data.value);
            var uid = $pagedetail.data("uid");

            Centauri.Utility.Loader.show("maincontent");

            $maincontent = $("#centauricms #content #maincontent");
            $crtModule = Centauri.current.module;

            // AJAX-call for rendering the Pagedetail partial (editing elements or data of the page itself)
            Centauri.Utility.Ajax(Centauri.Utility.URL("get").ajax + "Pagedetail", {
                _token: Centauri.token,
                crtModule: $crtModule,
                uid: uid,
                lid: data.value
            }, function(data) {
                // Returns the Partials/Pageedit Blade (which also renders contentelements for the backend-view)
                $maincontent.find(".content").html(data);
                Centauri.Utility.Loader.hide("maincontent");

                // Initializing Centauri's components (e.g. page functionalities or elements etc.)
                Centauri.Component.Page();
                Centauri.Component.Elements();
            });
        }
    });
};
