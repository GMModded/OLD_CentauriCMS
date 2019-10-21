Centauri.Elements.Dropdown = function(cb) {
    $centauridropdown = $(".centauri-dropdown");

    $centauridropdown.each(function() {
        $this = $(this);

        $this.find("input").click(function() {
            $(this).parent().find(".menu-view").addClass("show");
        });

        $centauridropdown.find(".item").click(function() {
            var value = $(this).data("value");
            var name = $.trim($(this).text());

            $(this).parent().parent().find("input").attr("value", name);
            $(this).parent().parent().find("input[type='hidden']").attr("value", value);

            $(this).parent().removeClass("show");

            if(typeof cb == "function") {
                var id = $(this).parent().parent().find("input:not([type='hidden'])").attr("id");

                cb({
                    value: value,
                    name: name,
                    id: id
                });
            }
        });
    });
};
