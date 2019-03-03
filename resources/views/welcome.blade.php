<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.css">

        <!-- Styles -->
        <style>
            /* html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            } */
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

                    <p class="level-item"><a href="{{ url('/') }}">Home</a></p>

                    @auth
                        <p class="level-item"><a href="{{ url('/auth/logout') }}">Logout</a></p>
                    @else
                        <p class="level-item"><a href="{{ url('/auth/logout') }}">Login</a></p>
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

            </div>
        </div>
    </body>
</html>
