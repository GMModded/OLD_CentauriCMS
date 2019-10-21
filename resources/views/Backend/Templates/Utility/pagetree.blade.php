<ul id="pages" class="list-group list-unstyled">
    @foreach($pages as $page)
        @if($page->pid == 0)
            <li data-uid="1" class="root">
                <i class="fas fa-globe mr-2"></i>

                <span>
                    {{ $page->title }}
                </span>
            </li>
        @else
            <li data-uid="{{ $page->uid }}">
                <i class="fas fa-file mr-2"></i>

                <span>
                    {{ $page->title }}
                </span>
            </li>
        @endif
    @endforeach
</ul>
