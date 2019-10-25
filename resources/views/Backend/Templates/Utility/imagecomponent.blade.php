<div id="modal-imagecropping" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg cascading-modal" role="document">
        <div class="modal-content">
            <div class="modal-header light-blue darken-3 white-text">
                <h4>
                    Cropper
                </h4>

                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body mb-0">
                <img class="img-fluid" src="{{ $image->source }}" />

                <div class="row">
                    <div class="col-12 px-5 mt-3 mb-2">
                        <button type="button" class="btn btn-success waves-effect waves-light" data-button-action="save">
                            <i class="fas fa-save"></i>
                        </button>

                        <button type="button" class="btn btn-warning waves-effect waves-light" data-button-action="reset">
                            <i class="fas fa-undo"></i>
                        </button>

                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal" data-button-action="close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script class="modal-imagecropping-script">
    $("#modal-imagecropping").modal("show");
    $("script.modal-imagecropping-script").remove();
</script>
