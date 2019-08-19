Centauri.Utility.Loader = {};

Centauri.Utility.Loader.show = function(id) {
    $id = $("#centauricms #content #" + id);
    $id.find(".loader").removeClass("d-none hidden");
    $id.find(".overlayer").removeClass("d-none hidden");
};

Centauri.Utility.Loader.hide = function(id) {
    $id = $("#centauricms #content #" + id);
    $id.find(".loader").addClass("hidden");
    $id.find(".overlayer").addClass("hidden");
};
