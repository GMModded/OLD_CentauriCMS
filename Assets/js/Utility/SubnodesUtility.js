var urlSubnodes = function() {
    var loc = window.location;
    
    var href = loc.href,
        host = loc.host,
        protocol = loc.protocol;

    href = href.replace(protocol + "//" + host, "");
    var nhref = href.split(href[0]);
    console.log(nhref);
};
