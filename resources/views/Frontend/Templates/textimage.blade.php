@if(isset($data["is_backgroundimage"]))
    <div id="ce_modul_textimage" style="background-image: url({{ $data['ce_image'] }});">
        <div class="text-view">
            <h2>
                {{ $data["ce_header"] }}
            </h2>

            <hr>

            <p>
                {{ $data["ce_subheader"] }}
            </p>
        </div>
    </div>
@else
    <div id="ce_modul_textimage">
        <div class="image-view">
            <img class="img-fluid" src="{{ $data['ce_image'] }}" />
        </div>

        <div class="text-view">
            <h2>
                {{ $data["ce_header"] }}
            </h2>

            <hr>

            <p>
                {{ $data["ce_subheader"] }}
            </p>
        </div>
    </div>

@endif
