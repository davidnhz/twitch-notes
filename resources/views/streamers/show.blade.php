
@extends('layouts.main')

@section('content')
    <div class="content">
        <a href="https://www.twitch.tv/{{ $streamer->nickname }}" target="_blank">
            <h1>{{ $streamer->nickname }}</h1>
        </a>
        <div id="twitch-embed"></div>

        <div class="columns">
            <div class="column">
                <h2>Notes</h2>
            </div>
            <div class="column">
                <h2>Latest videos</h2>
                @if ($videos)
                    <div class="list is-hoverable">
                        @foreach($videos as $video)
                            <a class="list-item" href="{{ $video->url }}">
                                @if ($video->thumbnail_url)
                                    <img src="{{ $video->thumbnail_url }}" alt="">
                                @endif
                                {{ $video->title }}
                            </a>
                        @endforeach
                        </div>
                @endif
            </div>
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
@endsection
