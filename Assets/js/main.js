/**
 * Centauri Core JS
 */
var Centauri = {};
    Centauri.init = {};

    Centauri.Component = {};
    Centauri.Utility = {};

    Centauri.current = {};
    Centauri.current.module = "home";


/**
 * Initialization of Centauri - after DOM is ready
 */
$(document).ready(function() {
    Centauri.token = $("meta[name='_token']").attr("content");

    Centauri.Component.Dashboard();
    Centauri.Component.Pagetree();
});

