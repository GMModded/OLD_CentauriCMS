{{-- {{ dd(get_defined_vars()["__data"]) }} --}}

<div class="page-detail" data-pid="{{ $page['pid'] }}">
    <div class="row">
        <div class="col">
            <h3>
                {{ $page["name"] }}
            </h3>
        </div>

        <div class="col-6 text-right">
            <a href="{{ url('ajax/pageedit?_token=' . $data['token'] . '&tool=showfrontend') }}" class="btn btn-info px-3 py-2 waves-effect waves-light" data-ajax="true" data-ajax-btn="showfrontend">
                <i class="fas fa-eye"></i>
            </a>

            <a href="{{ url('ajax/pageedit?_token=' . $data['token'] . '&tool=save') }}" class="btn btn-success px-3 py-2 waves-effect waves-light" data-ajax="true" data-ajax-btn="save">
                <i class="fas fa-save"></i>
            </a>

            <a href="{{ url('ajax/pageedit?_token=' . $data['token'] . '&tool=delete') }}" class="btn btn-danger px-3 py-2 waves-effect waves-light" data-ajax="true" data-ajax-btn="delete">
                <i class="fas fa-trash"></i>
            </a>
        </div>
    </div>

    <hr>

    @foreach($fieldsArray as $uid => $fieldArray)
        <div class="contentelement col-12" data-uid="{{ $uid }}">
            <div class="row">
                <div class="col">
                    <strong>
                        @lang("centauri/elements.$fieldArray[ctype]")
                    </strong>
                </div>

                <div class="col text-right">
                    <button class="btn btn-info waves-effect toggle-edit">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="bottom" style="display: none;">
                @foreach($fieldArray["fields"] as $ctype => $cfg)
                    <div class="field col">
                        {!! $cfg["html"] !!}
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
