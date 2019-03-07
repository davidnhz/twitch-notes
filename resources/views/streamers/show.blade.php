
@extends('layouts.main')

@section('content')
    <div class="content">
        <a href="https://www.twitch.tv/{{ $streamer->nickname }}" target="_blank">
            <h1>{{ $streamer->nickname }}</h1>
        </a>
        <div id="twitch-embed"></div>
    </div>
    <div class="columns">
        <div class="column">
            <h2 class="title">Notes</h2>
            <form action="/streamers/{{ $streamer->id }}/notes" method="POST">
                @csrf
                <div class="field">
                    <label class="label">Content</label>
                    <div class="control">
                        <textarea class="textarea" name="content" placeholder="Content"></textarea>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button class="button is-link" type="submit">Add Note</button>
                    </div>
                </div>
            </form>
            <div class="section">
                @if ($streamer->notes->count())
                    @foreach ($streamer->notes as $note)
                    <div class="columns">
                        <div class="column is-three-fifths is-offset-one-fifth">
                            <div class="card">
                                @if ($note->thumbnail)
                                    <div class="card-image">
                                        <figure class="image is-4by3">
                                        <img src="{{ $note->thumbnail }}" alt="">
                                        </figure>
                                    </div>
                                @endif
                                <div class="card-content">
                                    <div class="media">
                                        <div class="media-content">
                                            <p class="title is-6">{{ $note->stream_title }}</p>
                                            <p class="subtitle is-6">{{ $note->game_name }}</p>
                                        </div>
                                    </div>

                                    <div class="content">
                                        {{ $note->content }}
                                    <br>
                                    <time datetime="{{ $note->created_at }}">{{ $note->created_at }}</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="column">
            <h2 class="title">Latest videos</h2>
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
