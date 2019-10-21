<!DOCTYPE html>
<html lang="{{ $language ?? '' }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>{{ $page->title }}</title>

        <link rel="stylesheet" type="text/css" href="{{ url('public/css/frontend.css') }}">
    </head>

    <body>
        <div id="languages">
            @php
                $languages = \CentauriCMS\Centauri\Blade\Helper\LanguageHelper::languages();

                foreach($languages as $language) {
                    echo $language->rendered;
                }
            @endphp
        </div>

        <script src="{{ url('public/js/frontend.js') }}"></script>
    </body>
</html>
