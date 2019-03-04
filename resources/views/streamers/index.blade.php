<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Twitch Notes</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.css">

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

            <div class="top-right links">

            </div>

            <div class="content">
                <h4>Add Streamer</h4>

                <form action="/streamers" method="POST">
                    @csrf

                    <div class="field">
                        <label class="label">Name</label>
                        <div class="control">
                            <input class="input" type="text" name="nickname" placeholder="Stramer nickname">
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <button class="button is-link" type="submit">Add Streamer</button>
                        </div>
                    </div>

                </form>

                @if($streamers)
                    <h4>My favorite streamers</h4>
                    <ul>
                        @foreach($streamers as $streamer)
                            <li><a href="/streamers/{{ $streamer->id }}">{{ $streamer->nickname }}</a></li>
                        @endforeach
                    </ul>
                @endif

            </div>
        </div>
    </body>
</html>
