// Initialization of pagetree when loading the backend
Centauri.Component.Pagetree = function() {
    // AJAX-call for getting the pagetree
    Centauri.Utility.Ajax("Pagetree", {
        _token: Centauri.token
    }, function(data) {
        $pagetree = $("#centauricms #content #pagetree");
        $pagetree.find(".content").html(data);

        Centauri.Utility.Loader.hide("pagetree");

        $("#pages").sortable({
            placeholder: "drop-placeholder",
            items: "li:not(.root)"
        });

        $pages = $pagetree.find("#pages");
        $pages.find("li").each(function() {
            $page = $(this);
            var pid = $page.data("pid");

            // Page onclick event
            $page.click(function() {
                Centauri.Utility.Loader.show("maincontent");

                $maincontent = $("#centauricms #content #maincontent");
                $crtModule = Centauri.current.module;

                if($crtModule == "home" || $crtModule == "pages") {
                    // AJAX-call for rendering the Pagedetail partial (editing elements or data of the page itself)
                    Centauri.Utility.Ajax("Pagedetail", {
                        _token: Centauri.token,
                        crtModule: $crtModule,
                        pid: pid
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
        });
    });
};
