<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Twitch Notes</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css">
        <style>
            iframe {
                height: 480px;
            }
            .list p.list-item {
                margin: 0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <nav class="level">
                <div class="level-left">
                <div class="level-item">
                    <img src="{{ url('images/twitch.png') }}" width="50" alt="">
                    <p class="subtitle is-5">Twitch Notes</p>
                </div>

                </div>

                <div class="level-right">
                    @auth
                        <p class="level-item">
                            <a href="https://www.twitch.tv/{{ Auth::user()->username }}" target="_blank">
                                <img src="{{ Auth::user()->avatar }}" width="30" />
                            </a>
                        </p>
                        <p class="level-item">
                            <a href="https://www.twitch.tv/{{ Auth::user()->username }}" target="_blank">
                                {{ Auth::user()->username }}
                            </a>
                        </p>
                    @endauth


                    @auth
                        <p class="level-item"><a href="{{ url('/streamers') }}">Streamers</a></p>
                        <p class="level-item"><a href="{{ url('/logout') }}">Logout</a></p>
                    @else
                        <p class="level-item"><a href="{{ url('/login') }}">Login</a></p>
                    @endauth
                </div>
            </nav>

            <main id="content">
                @yield('content')
            </main>
        </div>
    </body>
</html>
