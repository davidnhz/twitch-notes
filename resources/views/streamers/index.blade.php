@extends('layouts.main')

@section('content')
    <div class="content">
        <div class="section">
            <div class="container">
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
        <div class="section">
            <div class="container">
                @if($streamers->count())
                    <h4>My favorite streamers</h4>
                    <div class="columns">
                        <div class="column is-half">
                            <table class="table is-bordered is-striped is-narrow is-hoverable">
                                <tbody>
                                    @foreach($streamers as $streamer)
                                        <tr>
                                            <td>
                                                <a href="/streamers/{{ $streamer->id }}">{{ $streamer->nickname }}</a>
                                            </td>
                                            <td>
                                                <form action="/streamers/{{ $streamer->id }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="block">
                                                        <span class="tag is-danger">
                                                            Delete
                                                            <button class="delete" type="submit">Delete Project</button>
                                                        </span>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                      @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

                @endif
            </div>
        </div>

    </div>
@endsection
