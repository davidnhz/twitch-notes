@extends('layouts.main')

@section('content')
        <div class="content">
            <div class="container">
                @if ($errors->any())
                    <div class="notification is-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h4 class="title">Add Streamer</h4>

                <form action="/streamers" method="POST">
                    @csrf

                    <div class="field">
                        <label class="label">Nickname</label>
                        <div class="control">
                            <input class="input" type="text" name="nickname" placeholder="Streamer nickname">
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
    <div class="section">
        <div class="container">
            <div class="columns">
                @if($streamers->count())
                <div class="column is-half">
                        <h4 class="title">My favorite streamers</h4>
                        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                            <tbody>
                                @foreach($streamers as $streamer)
                                    <tr>
                                        <td>
                                            <img src="{{ $streamer->avatar }}" alt="{{ $streamer->nickname }}" width="30">
                                        </td>
                                        <td>
                                            <a href="/streamers/{{ $streamer->id }}">
                                                {{ $streamer->nickname }}
                                                @if ($streamer->stream)
                                                    <span class="tag is-success">
                                                        {{ $streamer->stream }}
                                                        <span class="icon">
                                                            <i class="fas fa-video"></i>
                                                        </span>
                                                    </span>
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                            <form action="/streamers/{{ $streamer->id }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="block">
                                                    <a href="/streamers/{{ $streamer->id }}">
                                                        <span class="tag is-warning">
                                                            {{ $streamer->notes()->count() }}
                                                            <span class="icon">
                                                                <i class="fas fa-comment-alt"></i>
                                                            </span>
                                                        </span>
                                                    </a>
                                                    <span class="tag is-danger">
                                                        Delete
                                                        <button class="delete" type="submit">Delete stream</button>
                                                    </span>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="column is-half">
                    <h4 class="title">Latest Notes</h4>
                    <div id="app">
                        <notes-component :streamer="0"></notes-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
