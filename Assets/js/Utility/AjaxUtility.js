Centauri.Utility.Ajax = function(ajax, data, cb) {
    var url = "/ajax/" + ajax;

    /**
     * In case ajax-variable contains a full URL (by checking whether it contains http/https)
     * then changing url-variable to ajax
     */
    if(~ajax.indexOf("http://") || ~ajax.indexOf("https://")) {
        url = ajax;
    }

    $.ajax({
        url: url,
        data: data,

        success: function(data) {
            if(data == '{"error":"Token expired."}') {
                location.reload();
            } else {
                return cb(data);
            }
        }
    });
};
