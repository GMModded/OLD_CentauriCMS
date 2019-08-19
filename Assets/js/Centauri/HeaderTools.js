$(document).ready(function() {
    $("#centauricms #header #tools a[data-ajax='true']").each(function() {
        $a = $(this);

        $a.click(function(e) {
            e.preventDefault();
        });
    });
});
