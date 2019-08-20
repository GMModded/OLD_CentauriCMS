Centauri.Component.Dashboard = function() {
    $("#centauricms #dashboard .accordion .panel").each(function() {
        $panel = $(this);

        $panel.find("li[data-module]").on("click", function() {
            if(!$(this).hasClass("active")) {
                $("#centauricms #dashboard .accordion .panel li.active").removeClass("active");
                $(this).addClass("active");

                var dataModule = $(this).data("module");
                Centauri.current.module = dataModule;

                $maincontent = $("#centauricms #content #maincontent");
                $maincontent.find(".content").html("");
            }
        });
    });
};
