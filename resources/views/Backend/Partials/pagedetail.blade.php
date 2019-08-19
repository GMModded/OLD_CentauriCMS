{{-- {{ dd(get_defined_vars()["__data"]) }} --}}

<div class="page-detail">
    <div class="top">
        <h3>
            {{ $page["name"] }}
        </h3>

        <div>
            <select name="" id="">
                <option value="de" selected>Deutsch</option>
                <option value="en">English</option>
            </select>

            <select class="mdb-select md-form">
                <option value="" disabled selected>
                    Choose your option
                </option>

                <option value="" data-icon="https://mdbootstrap.com/img/Photos/Avatars/avatar-1.jpg" class="rounded-circle">
                    example 1
                </option>

                <option value="" data-icon="https://mdbootstrap.com/img/Photos/Avatars/avatar-2.jpg" class="rounded-circle">
                    example 2
                </option>

                <option value="" data-icon="https://mdbootstrap.com/img/Photos/Avatars/avatar-3.jpg" class="rounded-circle">
                    example 3
                </option>
            </select>

            <label class="mdb-main-label">
                Example label
            </label>
        </div>
    </div>

    <hr>

    @foreach($elements as $uid => $element)
        <div class="contentelement col-12">
            <p>
                <strong>
                    @lang("centauri/elements.$element[ctype]")
                </strong>

                <a href="{{ url('ajax/elementedit?_token=' . $data['token'] . '') }}" class="btn" data-ajax="true">
                    <i class="fas fa-pen-alt"></i>
                </a>

                @foreach($element["data"] as $ctype => $value)
                    {!! $elementsConfig[$ctype]["html"] !!}
                @endforeach
            </p>
        </div>
    @endforeach
</div>
