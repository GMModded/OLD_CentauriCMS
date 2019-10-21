{{-- {{ dd(get_defined_vars()["__data"]) }} --}}

<div id="modal-newelement" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg cascading-modal" role="document">
        <div class="modal-content">
            <div class="modal-header light-blue darken-3 white-text">
                <h4 class="title">
                    <i class="fa fa-newspaper-o"></i>
                    @lang("centauri/messages.header.newelement")
                </h4>

                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body mb-0">
                <ul class="nav nav-tabs md-tabs list-unstyled" id="myTabMD" role="tablist">
                    @foreach($tabs as $tab => $palettes)
                        <li class="nav-item">
                            @if($loop->first)
                                <a class="nav-link waves-effect active" id="{{ $tab }}-tab-md" data-toggle="tab" href="#{{ $tab }}-md" role="tab" aria-controls="{{ $tab }}-md" aria-selected="true">
                                    @lang("centauri/messages.labels.tabs.$tab")
                                </a>
                            @else
                                <a class="nav-link waves-effect" id="{{ $tab }}-tab-md" data-toggle="tab" href="#{{ $tab }}-md" role="tab" aria-controls="{{ $tab }}-md" aria-selected="true">
                                    @lang("centauri/messages.labels.tabs.$tab")
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content card p-3" id="myTabContentMD">
                    @foreach($tabs as $tab => $palettes)
                        @if($loop->first)
                            <div class="tab-pane fade show active" id="{{ $tab }}-md" role="tabpanel" aria-labelledby="{{ $tab }}-tab-md">
                                @foreach($palettes as $ctype => $palette)
                                    <div class="contentelement col-12" data-ctype="{{ $ctype }}">
                                        <div class="top">
                                            <strong>
                                                @lang("centauri/elements.$ctype")
                                            </strong>
                                        </div>

                                        <div class="bottom row" style="display: none;">
                                            @foreach($palette["configs"] as $field => $cfg)
                                                <div class="field col-12">
                                                    @if(isset($cfg["label"]))
                                                        <label>
                                                            {{ $cfg["label"] }}
                                                        </label>
                                                    @endif

                                                    @if(isset($cfg["html"]))
                                                        <div class="content">
                                                            {!! $cfg["html"] !!}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        
                        @else
                            <div class="tab-pane fade show" id="{{ $tab }}-md" role="tabpanel" aria-labelledby="{{ $tab }}-tab-md">
                                @foreach($palettes as $ctype => $palette)
                                    <div class="contentelement col-12">
                                        <div class="top">
                                            <strong>
                                                @lang("centauri/elements.$ctype")
                                            </strong>
                                        </div>

                                        <div class="bottom row" style="display: none;">
                                            @foreach($palette["configs"] as $field => $cfg)
                                                <div class="field col-12">
                                                    @if(isset($cfg["label"]))
                                                        <label>
                                                            {{ $cfg["label"] }}
                                                        </label>
                                                    @endif

                                                    @if(isset($cfg["html"]))
                                                        <div class="content">
                                                            {!! $cfg["html"] !!}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>

                <a href="{{ url('ajax/wizard/newelementwizard?_token=' . $data['token'] . '') }}" class="mt-4 float-right btn btn-primary px-3 py-2 waves-effect waves-light" data-ajax="true" data-ajax-btn="savenewelement">
                    <i class="fas fa-save"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script id="modal-newelement-script">
    $("#modal-newelement").modal("show");
    $("script#modal-newelement-script").remove();
</script>
