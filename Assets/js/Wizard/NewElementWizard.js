Centauri.Wizard.NewElement = function() {
    Centauri.Component.Page();

    $modal = $("#modal-newelement");
    $contentelements = $modal.find(".tab-content .contentelement");

    $contentelements.each(function() {
        $(this).find(".top > strong").click(function() {
            $contentelement = $(this).parent().parent();
            $bottom = $contentelement.find(".bottom");

            $contentelements.each(function() {
                if(!$(this).is($contentelement)) {
                    $(this).find(".bottom").slideUp();

                    if($(this).hasClass("active")) $(this).removeClass("active");
                }
            });

            $bottom.slideToggle();
            $contentelement.toggleClass("active");
        });
    });
};
