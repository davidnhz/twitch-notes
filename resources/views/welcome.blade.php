@extends('layouts.main')

@section('content')
    <div class="content">
        <h4>Welcome!</h4>
        @auth
            <p>Go to <a href="{{ url('/streamers') }}">Streamers</a> to start!</p>
        @else
            <p>Please <a href="{{ url('/login') }}">login</a> to start!</p>
        @endauth
    </div>
@endsection
