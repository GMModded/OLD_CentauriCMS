<div id="ce_modul_header">
    <div class="text-view">
        <h1>
            {{ $data["ce_header"] }}
        </h1>

        <h2>
            {{ $data["ce_subheader"] }}
        </h2>

        @if($data["ce_description"])
            <hr>

            {!! $data["ce_description"] !!}
        @endif
    </div>
</div>
