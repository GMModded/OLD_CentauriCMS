<div id="ce_headerteaserimage">
    @if(isset($data->ce_header))
        <h2>
            {{ $data->ce_header }}
        </h2>
    @endif

    @if(isset($data->ce_subheader))
        <h4>
            {{ $data->ce_subheader }}
        </h4>
    @endif
</div>
