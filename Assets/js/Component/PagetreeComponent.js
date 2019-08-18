// Initialization of pagetree when loading the backend
Centauri.init.pagetree = function() {
    // AJAX-call for getting the pagetree
    Centauri.Utility.ajax("Pagetree", {
        _token: Centauri.token
    }, function(data) {
        $pagetree = $("#centauricms #content #pagetree");

        $pagetree.find(".content").html(data);
        $pagetree.find(".loader").addClass("hidden");
        $pagetree.find(".overlayer").addClass("hidden");

        $pages = $pagetree.find("#pages");
        $pages.find("li").each(function() {
            $page = $(this);
            var uid = $page.data("uid");

            // Page onclick event
            $page.click(function() {
                $maincontent = $("#centauricms #content #maincontent");
                $maincontent.find(".loader").removeClass("d-none hidden");
                $maincontent.find(".overlayer").removeClass("d-none hidden");

                // AJAX-call for rendering the Pagedetail partial (editing elements or data of the page itself)
                Centauri.Utility.ajax("Pagedetail", {
                    _token: Centauri.token,
                    uid: uid
                }, function(data) {
                    $maincontent.find(".content").html(data);
                    $maincontent.find(".loader").addClass("hidden");
                    $maincontent.find(".overlayer").addClass("hidden");
                });
            });
        });
    });
};
