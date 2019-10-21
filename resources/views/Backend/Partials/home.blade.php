{{-- {{ dd(get_defined_vars()["__data"]) }} --}}

<div class="home-detail">
    @if(isset($page->publicUrl))
        <iframe src="{{ $page->publicUrl }}"></iframe>
    @endif
</div>
