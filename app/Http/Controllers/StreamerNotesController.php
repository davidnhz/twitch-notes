<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Streamer;
use App\StreamerNote;

class StreamerNotesController extends Controller
{
    protected $client, $headers;

    public function __construct()
    {
        $this->middleware('auth');

        $this->client = new \GuzzleHttp\Client();
        $this->headers = ['Client-ID' => env('TWITCH_KEY')];
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
        $request = $this->client->request('GET', env('TWITCH_API_URI') . 'streams', [
            'headers' => $this->headers,
            'query' => ['user_id' => $streamer->twitch_id],
        ]);

        if ($request->getStatusCode() === 200)
        {
            $response = json_decode($request->getBody()->getContents());

            if ($response->data)
            {
                return $response->data[0];
            }
        }

        return [];
    }

    public function getGameName($game_id)
    {
        $request = $this->client->request('GET', env('TWITCH_API_URI') . 'games', [
            'headers' => $this->headers,
            'query' => ['id' => $game_id],
        ]);

        if ($request->getStatusCode() === 200)
        {
            $response = json_decode($request->getBody()->getContents());
            if ($response->data)
            {
                return $response->data[0]->name;
            }
        }

        return 'Offline';
    }
}
