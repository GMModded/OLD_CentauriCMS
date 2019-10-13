/**
 * Centauri Core JS
 */
var Centauri = {};
    Centauri.init = {};

    Centauri.Component = {};
    Centauri.Utility = {};
    Centauri.Wizard = {};

    Centauri.current = {};
    Centauri.current.module = "home";

    Centauri.scrollTops = {};
    Centauri.scrollTops.maincontent = 0;


/**
 * Initialization of Centauri - after DOM is ready
 */
var isScrolling = false;
$(document).ready(function() {
    Centauri.token = $("meta[name='_token']").attr("content");

    Centauri.Component.Dashboard();
    Centauri.Component.Pagetree();

    // $("#maincontent").on("scroll", function(e) {
    //     if(!isScrolling) {
    //         isScrolling = true;

    //         $(this).animate({
    //             scrollTop: $(this).scrollTop() + 100},

    //             {
    //                 complete: function() {
    //                     isScrolling = false;
    //                 }
    //         }, 1);
    //     }
    // });
});
