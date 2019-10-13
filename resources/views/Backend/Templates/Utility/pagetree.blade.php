<ul id="pages" class="list-group list-unstyled">
    @foreach($pages as $pid => $page)
        @if($pid == 0)
            <li data-pid="0" class="root">
                <i class="fas fa-globe mr-2"></i>

                <span>
                    {{ $page["name"] }}
                </span>
            </li>
        @else
            <li data-pid="{{ $pid }}">
                <i class="fas fa-file mr-2"></i>

                <span>
                    {{ $page["name"] }}
                </span>
            </li>
        @endif
    @endforeach
</ul>
