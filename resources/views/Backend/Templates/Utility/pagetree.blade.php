{{-- {{ dd(get_defined_vars()["__data"]) }} --}}

<ul id="pages" class="list-group list-unstyled">
    @foreach($pages as $uid => $page)
        @if($uid == 0)
            <li data-uid="0">
                <i class="fas fa-globe mr-2"></i>

                <span>
                    {{ $page["name"] }}
                </span>
            </li>
        @else
            <li data-uid="{{ $uid }}">
                <i class="fas fa-file mr-2"></i>

                <span>
                    {{ $page["name"] }}
                </span>
            </li>
        @endif
    @endforeach    
</ul>
