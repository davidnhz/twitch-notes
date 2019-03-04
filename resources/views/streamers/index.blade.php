@extends('layouts.main')

@section('content')
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
@endsection
