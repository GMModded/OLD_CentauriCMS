Centauri.init.pagetree = function() {
    Centauri.Utility.ajax("Pagetree", {
        _token: Centauri.token
    }, function(data) {
        $pagetree = $("#centauricms #content #pagetree");

        $pagetree.find(".content").html(data);
        $pagetree.find(".loader").addClass("hidden");

        $pages = $pagetree.find("#pages");
        $pages.find("li").each(function() {
            $page = $(this);

            var uid = $page.data("uid");

            $page.click(function() {
                $maincontent = $("#centauricms #content #maincontent");
                $maincontent.find(".loader").removeClass("d-none hidden");

                Centauri.Utility.ajax("Pagedetail", {
                    _token: Centauri.token,
                    uid: uid
                }, function(data) {
                    $maincontent.find(".content").html(data);
                    $maincontent.find(".loader").addClass("hidden");
                });
            });
        });
    });
};
