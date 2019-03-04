<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Twitch Notes</title>

        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"> --}}

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css">
        <style>
            iframe {
                height: 480px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <nav class="level">
                <div class="level-left">
                <div class="level-item">
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
                    <p class="level-item">{{ Auth::user()->username }}</p>
                    @endauth


                    @auth
                        <p class="level-item"><a href="{{ url('/streamers') }}">Streamers</a></p>
                        <p class="level-item"><a href="{{ url('/logout') }}">Logout</a></p>
                    @else
                        <p class="level-item"><a href="{{ url('/login') }}">Login</a></p>
                    @endauth
                </div>
            </nav>


            <div class="content">
                <a href="https://www.twitch.tv/{{ $streamer->nickname }}" target="_blank">
                    <h1>{{ $streamer->nickname }}</h1>
                </a>
                <div id="twitch-embed"></div>
            </div>
        </div>

    <!-- Load the Twitch embed script -->
    <script src="https://embed.twitch.tv/embed/v1.js"></script>

    <!-- Create a Twitch.Embed object that will render within the "twitch-embed" root element. -->
    <script type="text/javascript">
        new Twitch.Embed("twitch-embed", {
          width: 1152,
          height: 800,
          channel: "{{ $streamer->nickname }}"
        });
    </script>
    </body>
</html>
