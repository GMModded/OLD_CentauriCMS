Centauri.Utility.ajax = function(ajax, data, cb) {
    $.ajax({
        url: "//localhost/CentauriCMS/ajax/" + ajax,
        data: data,

        success: function(data) {
            return cb(data);
        }
    });
};
