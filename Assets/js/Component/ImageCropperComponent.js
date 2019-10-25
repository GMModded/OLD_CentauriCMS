var cropperObj;

Centauri.Component.ImageCropper = function() {
    $imagecroppers = $("#centauricms #content .page-detail .image-cropper");

    $imagecroppers.each(function() {
        $img = $(this).find("img");

        $img.dblclick(function() {
            $img = $(this);

            var id = $img.attr("id"),
                uid = $img.data("uid"),
                width = $img.attr("width") / 3,
                height = $img.attr("height") / 3;

            Centauri.Utility.Ajax(Centauri.Utility.URL("get").ajax + "ImageComponent", {
                _token: Centauri.token,
                uid: uid
            }, function(data) {
                $("body").append(data);

                $modal = $("#modal-imagecropping");

                $modalImg = $modal.find("img");
                $modalImg.attr("id", id);

                $img.removeAttr("id");

                var modalImgEl = document.getElementById(id);
                cropperObj = new Cropper(modalImgEl, {
                    minContainerHeight: height,
                    minContainerWidth: width,
                    minCanvasHeight: height,
                    minCanvasWidth: width,
                });

                $modalBtns = $modal.find(".row button");
                $modalBtns.each(function() {
                    $btn = $(this);

                    $btn.click(function() {
                        var action = $(this).data("button-action");

                        if(action == "save") {
                            var croppedCanvas = cropperObj.getCroppedCanvas().toDataURL('image/jpeg');
                            console.log(croppedCanvas);
                        }

                        if(action == "reset") {
                            cropperObj.reset();
                        }

                        if(action == "close") {
                            $modal.modal("dispose");
                        }
                    });
                });
            });
        });
    });
};
