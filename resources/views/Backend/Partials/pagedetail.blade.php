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
        </div>
    </div>

    <hr>

    @foreach($elements as $uid => $element)
        <div class="contentelement col-12">
            <p>
                <strong>
                    @lang("centauri/elements.$element[ctype]")
                </strong>
            </p>
        </div>
    @endforeach
</div>
