var Centauri = {};
Centauri.init = {};
Centauri.Utility = {};


$(document).ready(function() {
    Centauri.token = $("meta[name='_token']").attr("content");

    Centauri.init.dashboard();
    Centauri.init.pagetree();
});
