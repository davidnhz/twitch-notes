<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Streamer;
use App\StreamerNote;
use App\Helpers\TwitchClient;

class StreamerNotesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Streamer $streamer)
    {
        $attributes = request()->validate([
            'content' => ['required', 'min:3']
        ]);

        if ($stream = $this->getStream($streamer))
        {
            $attributes['stream_title'] = $stream->title;
            $attributes['thumbnail'] = str_replace_first('{height}','216', str_replace_first('{width}', '288', $stream->thumbnail_url));
            $attributes['game_name'] = $this->getGameName($stream->game_id);
        } else {
            $attributes['game_name'] = 'Offline';
            $attributes['stream_title'] = 'Offline';
        }

        $streamer->addNote($attributes);

        return back();
    }

    public function getStream(Streamer $streamer)
    {
        $response_data = TwitchClient::instance()->clientRequest([
            'user_id' => $streamer->twitch_id
        ], 'streams');

        if ($response_data)
        {
            return $response_data[0];
        }

        return [];
    }

    public function getGameName($game_id)
    {
        $response_data = TwitchClient::instance()->clientRequest([
            'id' => $game_id
        ], 'games');

        if ($response_data)
        {
            return $response_data[0]->name;
        }

        return 'Offline';
    }
}
