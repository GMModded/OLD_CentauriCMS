Centauri.Utility.URL = function(type) {
    switch(type) {
        case "get":
            return {
                "backend": location.href + "/../../",
                "ajax": location.href + "/../../ajax/"
            };
    
        default:
            break;
    }
};
