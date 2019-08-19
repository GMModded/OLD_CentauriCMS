// Initialization of pagetree when loading the backend
Centauri.init.pagetree = function() {
    // AJAX-call for getting the pagetree
    Centauri.Utility.ajax("Pagetree", {
        _token: Centauri.token
    }, function(data) {
        $pagetree = $("#centauricms #content #pagetree");
        $pagetree.find(".content").html(data);

        Centauri.Utility.Loader.hide("pagetree");

        $("#pages").sortable({
            placeholder: "drop-placeholder"
        });

        $pages = $pagetree.find("#pages");
        $pages.find("li").each(function() {
            $page = $(this);
            var uid = $page.data("uid");

            // Page onclick event
            $page.click(function() {
                Centauri.Utility.Loader.show("maincontent");

                $maincontent = $("#centauricms #content #maincontent");
                $crtModule = Centauri.current.module;

                if($crtModule == "home" || $crtModule == "pages") {
                    // AJAX-call for rendering the Pagedetail partial (editing elements or data of the page itself)
                    Centauri.Utility.ajax("Pagedetail", {
                        _token: Centauri.token,
                        crtModule: $crtModule,
                        uid: uid
                    }, function(data) {
                        $maincontent.find(".content").html(data);
                        Centauri.Utility.Loader.hide("maincontent");
                    });
                }
            });
        });
    });
};

// $("#sortable4").sortable({
//     placeholder: 'drop-placeholder'
// });
