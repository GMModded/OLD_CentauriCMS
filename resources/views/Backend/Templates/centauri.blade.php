{{-- {{ dump(App::getLocale()) }} --}}

<!DOCTYPE HTML>
<html>
    <head>
        <base href="{{ $data["_ENV"]["APP_URL"] }}" />
        <title>{{ $data["_ENV"]["APP_NAME"] }} » {{ $data["label"]["state"] }}</title>
        <meta name="_token" content="{!! csrf_token() !!}" />
        <link rel="stylesheet" href="{{ $data['_ENV']['APP_URL'] }}/public/css/centauri.min.css">
        <link href="https://fonts.googleapis.com/css?family=Comfortaa&display=swap" rel="stylesheet">
    </head>

    <body>
        <div id="centauricms" class="d-flex">
            @centauri("session-init")

            <section id="dashboard">
                <div class="top mt-3 text-center">
                    <h3>
                        Centauri

                        <small>
                            v{{ \CentauriCMS\Centauri\Utility\VersionUtility::findByName("Core") }}
                        </small>
                    </h3>
                </div>

                <hr>

                <div class="bottom">
                    @foreach($data["modules"] as $mainKey => $module)
                        <ul class="list-unstyled accordion">
                            <li class="parent">
                                <i class="{{ $data['modules'][$mainKey]['icon'] }}"></i>

                                <span>
                                    @lang($module["name"])
                                </span>
                            </li>

                            <ul class="list-unstyled panel">
                                @foreach($module["items"] as $key => $item)
                                    @if($mainKey == "web" && $loop->first)
                                        <li class="active w-100 waves-input-wrapper waves-effect" data-module="{{ $key }}">
                                            <i class="{{ $item['icon'] }}"></i>

                                            <span>
                                                @lang($item["label"])
                                            </span>
                                        </li>
                                    @else
                                        <li class="w-100 waves-input-wrapper waves-effect" data-module="{{ $key }}">
                                            <i class="{{ $item['icon'] }}"></i>

                                            <span>
                                                @lang($item["label"])
                                            </span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </ul>
                    @endforeach
                </div>
            </section>

            <section id="content" class="col px-4">
                <section id="header">
                    <div id="tools" class="float-right">
                        <a href="{{ url('ajax/clearcache?_token=' . $data['token'] . '') }}" class="btn btn-default btn-lg btn-default h-100 mr-2 m-0 align-items-center p-2" data-ajax="true">
                            <i class="fas fa-bolt"></i>
                        </a>

                        <a href="{{ url('action/logout?_token=' . $data['token'] . '') }}" class="btn btn-danger h-100 m-0 align-items-center p-2">
                            <i class="fas fa-sign-out-alt"></i>

                            @lang("centauri/messages.header.logout")
                        </a>
                    </div>
                </section>

                <div class="container-fluid">
                    <div class="row">
                        <div class="left col-3 p-0 mr-4 overflow-hidden">
                            <div id="pagetools" class="centauri-box mb-4" style="height: 50px;">
                                <a clsas="btn-floating">
                                    <i class="fas fa-file"></i>
                                </a>
                            </div>

                            <div id="pagetree" class="centauri-box">
                                <div class="overlayer"></div>

                                <div class="loader">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>

                                <div class="content"></div>
                            </div>
                        </div>

                        <div id="maincontent" class="centauri-box col">
                            <div class="overlayer d-none"></div>

                            <div class="loader d-none">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>

                            <div class="content"></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <script async src="{{ $data['_ENV']['APP_URL'] }}/public/js/centauri.min.js"></script>

        @if(session()->has("LOGIN_STATE"))
            @if(session()->get("LOGIN_STATE") == "200")
                {{ \CentauriCMS\Centauri\Utility\ToastUtility::show(
                    true,

                    app("translator")->getFromJson("centauri/messages.welcome.title", ["username" => session()->get("username")]),
                    app("translator")->getFromJson("centauri/messages.welcome.description")
                )}}
            @endif
        @endif
    </body>
</html>
