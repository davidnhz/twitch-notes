@extends('layouts.main')

@section('content')
    <div class="content">
        <h4>Welcome to Twitch Notes!</h4>
        <p>Twitcher Notes is an application where you can create personal notes during live streams of your favorite streamers.</p>
        <p>You just have to add the nickname of your favorites streamers and then you are going to be able to add notes while you are watching the live stream.</p>
        <p>You can revisit your ideas and comments created during streams for education, analysis or entertainment purposes.</p>
        @auth
            <p>Go to <a href="{{ url('/streamers') }}">Streamers</a> to start!</p>
        @else
            <p>Please <a href="{{ url('/login') }}">login</a> with your Twitch account to start!</p>
        @endauth
    </div>
@endsection
