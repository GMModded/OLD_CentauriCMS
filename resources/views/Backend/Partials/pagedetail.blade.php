{{-- {{ dd(get_defined_vars()["__data"]) }} --}}

<div class="page-detail" data-uid="{{ $page->uid }}" data-pid="{{ $page->pid }}">
    <div class="row">
        <div class="col-9">
            <div class="d-flex">
                <div class="input-group mr-3">
                    <input type="text" class="col" id="pagetitle" placeholder="Page title" value="{{ $page->title }}">

                    <div class="icon-view">
                        <i class="fa fa-heading fa-lg fa-fw"></i>
                    </div>
                </div>

                <div class="input-group mr-3">
                    <input type="text" class="col" id="pageurlmasks" placeholder="Page Masks" value="{{ $page->urlmasks }}">

                    <div class="icon-view">
                        <i class="fa fa-link fa-lg fa-fw"></i>
                    </div>
                </div>
            
                <div class="input-group centauri-dropdown">
                    <input type="hidden" name="language" value="{{ $language->uid }}">
                    <input type="text" class="col" id="language" name="languagelabel" value="{{ $language->title }}">

                    <div class="icon-view">
                        <i class="fa fa-language fa-lg fa-fw"></i>
                    </div>

                    <div class="menu-view w-100">
                        @foreach($languages as $languageitem)
                            @if(!$languageitem->hidden)
                                @if($languageitem->uid == $language->uid)
                                    <div class="item" data-value="{{ $languageitem->uid }}">
                                        {{ $languageitem->title }}
                                    </div>
                                @else
                                    <div class="item" data-value="{{ $languageitem->uid }}">
                                        {{ $languageitem->title }}
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col text-right">
            <a href="{{ url('ajax/pageedit?_token=' . $data['token'] . '&tool=showfrontend') }}" class="btn btn-info px-3 py-2 waves-effect waves-light" data-ajax="true" data-ajax-btn="showfrontend">
                <i class="fas fa-external-link-alt"></i>
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

    @foreach($backendLayout["rowCols"] as $colPos => $rowCol)
        <a href="{{ url('ajax/pageedit?_token=' . $data['token'] . '&tool=newelement') }}" class="btn btn-primary px-3 py-2 mb-4 ml-0 waves-effect waves-light" data-ajax="true" data-ajax-btn="newelement" data-index="0">
            <i class="fas fa-plus"></i>
        </a>

        <div class="row" data-colPos="{{ $colPos }}">
            @foreach($elements[$colPos] as $element)
                <div class="contentelement col-12">
                    <h3>
                        a
                    </h3>
                </div>
            @endforeach

            @if(!$loop->last)
                <a href="{{ url('ajax/pageedit?_token=' . $data['token'] . '&tool=newelement') }}" class="btn btn-primary px-3 py-2 mb-4 ml-0 waves-effect waves-light" data-ajax="true" data-ajax-btn="newelement" data-index="0">
                    <i class="fas fa-plus"></i>
                </a>
            @endif
        </div>

        @if($loop->last)
            <a href="{{ url('ajax/pageedit?_token=' . $data['token'] . '&tool=newelement') }}" class="btn btn-primary px-3 py-2 mb-4 ml-0 waves-effect waves-light" data-ajax="true" data-ajax-btn="newelement" data-index="0">
                <i class="fas fa-plus"></i>
            </a>
        @endif
    @endforeach

    {{-- @foreach($elements as $element)
        <div class="contentelement col-12" data-uid="{{ $element->uid }}">
            <div class="row top">
                <div class="col">
                    <strong>
                        @lang("centauri/elements.$element->CType")
                    </strong>
                </div>

                <div class="top-right">
                    <button class="btn btn-info waves-effect" data-toggle="edit">
                        <i class="fas fa-pencil-alt"></i>
                    </button>

                    <button class="btn btn-warning waves-effect" data-toggle="hidden">
                        @if($element->hidden)
                            <i class="fas fa-eye-slash"></i>
                        @else
                            <i class="fas fa-eye"></i>
                        @endif
                    </button>

                    <button class="btn btn-danger waves-effect" data-toggle="delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>

            <div class="row bottom" style="display: none;">
                @foreach($element->fields as $field)
                    <div class="field col-12">
                        @if(isset($field["label"]))
                            <label>
                                {{ $field["label"] }}
                            </label>
                        @endif

                        @if(isset($field["html"]))
                            <div class="content">
                                {!! $field["html"] !!}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <a href="{{ url('ajax/pageedit?_token=' . $data['token'] . '&tool=newelement') }}" class="btn btn-primary px-3 py-2 mb-4 ml-0 waves-effect waves-light" data-ajax="true" data-ajax-btn="newelement" data-index="{{ $loop->iteration }}">
            <i class="fas fa-plus"></i>
        </a>
    @endforeach --}}
</div>
