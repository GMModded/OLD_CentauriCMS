{{-- {{ dd(get_defined_vars()) }} --}}

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
        <div id="centauricms">
            <div class="login">
                <div class="container">
                    <div class="row">
                        <div class="wrapper">
                            <h2 class="title text-uppercase text-center font-weight-bold">
                                Centauri - Login
                            </h2>

                            <form method="POST" action="{{ $data['_ENV']['APP_URL'] }}/action/login" autocomplete="off" role="presentation">
                                @csrf

                                <div class="input-group">
                                    <input type="text" class="form-control" id="username" placeholder="Username" name="username">

                                    <div class="icon-view">
                                        <i class="fa fa-user fa-lg fa-fw"></i>
                                    </div>
                                </div>

                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" placeholder="Password" name="password">

                                    <div class="icon-view">
                                        <i class="fa fa-key fa-lg fa-fw"></i>
                                    </div>
                                </div>

                                <div class="bottom mt-4 d-flex">
                                    <div class="col-8 p-0 input-group centauri-dropdown">
                                        <input type="text" class="form-control" id="language" name="language" value>

                                        <div class="icon-view">
                                            <i class="fa fa-language fa-lg fa-fw"></i>
                                        </div>
                                    </div>

                                    <span class="w-100 waves-input-wrapper waves-effect waves-light">
                                        <input type="submit" value="Log in" class="w-100 centauri-colors bg-blackblue">
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script async src="{{ $data['_ENV']['APP_URL'] }}/public/js/centauri.min.js"></script>

        @if(session()->has("LOGIN_STATE"))
            @if(session()->get("LOGIN_STATE") == "404")
                {{ \CentauriCMS\Centauri\Utility\ToastUtility::show(
                    true,

                    app("translator")->getFromJson("centauri/messages.error.failed.login.title"),
                    app("translator")->getFromJson("centauri/messages.error.failed.login.description"),

                    "error"
                )}}
            @endif
        @endif
    </body>
</html>
