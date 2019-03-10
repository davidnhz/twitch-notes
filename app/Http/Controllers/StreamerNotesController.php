<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

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
            'content' => ['required', 'min:1']
        ]);

        if ($stream = $this->getStream($streamer))
        {
            $attributes['stream_title'] = $stream->title;
            $attributes['game_name'] = $this->getGameName($stream->game_id);
            $stream_thumbnail = str_replace_first('{height}','216', str_replace_first('{width}', '288', $stream->thumbnail_url));

            // Save current stream screenshot localy.
            $contents = file_get_contents($stream_thumbnail);
            $last_note = StreamerNote::orderBy('id', 'desc')->first();

            // Use note_id to name stream screenshot to make it unique
            $name = ($last_note ? $last_note->id + 1 : 1) . '-' . substr($stream_thumbnail, strrpos($stream_thumbnail, '/') + 1);
            $storage = Storage::put($name, $contents);

            $attributes['thumbnail'] = $name;
        } else {
            $attributes['game_name'] = 'Offline';
            $attributes['stream_title'] = 'Offline';
        }

        $note = $streamer->addNote($attributes);
        $note->thumbnail = $note->thumbnail ? Storage::url($note->thumbnail) : $note->thumbnail;
        $note->created = date('l jS \of F Y h:i:s A', strtotime($note->created_at));

        return $note;
    }

    public function get(Streamer $streamer)
    {
        $this->authorize('owns', $streamer);

        $notes = $streamer->notes;
        foreach ($notes as $note) {
            $note->created = date('l jS \of F Y h:i:s A', strtotime($note->created_at));
            $note->thumbnail = $note->thumbnail ? Storage::url( $note->thumbnail) : $note->thumbnail;
        }

        return $notes;
    }

    public function getAll()
    {
        $notes = auth()->user()->notes;

        foreach ($notes as $note) {
            $note->created = date('l jS \of F Y h:i:s A', strtotime($note->created_at));
            $note->thumbnail = $note->thumbnail ? Storage::url( $note->thumbnail) : $note->thumbnail;
        }

        return $notes;
    }

    public function destroy(Streamer $streamer, StreamerNote $note)
    {
        $this->authorize('owns', $streamer);

        $note->delete();
    }

    public function update(Streamer $streamer, StreamerNote $note)
    {
        $this->authorize('owns', $streamer);

        $attributes = request()->validate([
            'content' => ['required', 'min:1']
        ]);

        $note->update($attributes);

        $note->created = date('l jS \of F Y h:i:s A', strtotime($note->created_at));
        $note->thumbnail = $note->thumbnail ? Storage::url( $note->thumbnail) : $note->thumbnail;

        return $note;
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
