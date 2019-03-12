<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use App\Streamer;
use App\Helpers\TwitchClient;

class StreamersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $streamers = auth()->user()->streamers;

        foreach ($streamers as $streamer) {
            $stream = $this->getStream($streamer);
            $streamer->stream = $stream ? $stream->type : '';
        }

        return view('streamers.index', compact('streamers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $this->validateStreamer();
        $attributes['user_id'] = auth()->id();
        $attributes['nickname'] = str_replace(' ', '', $attributes['nickname']);

        if ($errors = $this->checkIfValid($attributes))
        {
            return redirect()->back()->withErrors($errors);
        }

        $response_data = TwitchClient::instance()->clientRequest([
            'login' => $attributes['nickname'],
        ], 'users');

        if ($response_data)
        {
            $attributes['twitch_id'] = $response_data[0]->id;
            $attributes['avatar'] = $response_data[0]->profile_image_url;

            $streamer = Streamer::create($attributes);
        }

        return redirect('/streamers');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Streamer $streamer)
    {
        $this->authorize('owns', $streamer);

        $videos = [];

        $videos = TwitchClient::instance()->clientRequest([
            'user_id' => $streamer->twitch_id,
            'first' => 10,
        ], 'videos');

        if ($videos)
        {
            $videos = array_map(function($video){
                $video->thumbnail_url = str_replace_first('%{height}','60', str_replace_first('%{width}', '100', $video->thumbnail_url));
                return $video;
            }, $videos);
        }

        return view('streamers.show', compact('streamer', 'videos'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Streamer $streamer)
    {
        $this->authorize('owns', $streamer);

        $streamer->delete();

        return redirect('/streamers');
    }

    protected function validateStreamer()
    {
        return request()->validate([
            'nickname' => ['required', 'min:3'],
        ]);
    }

     /**
     * Check if streamer already stored and if streamer is valis twitch user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function checkIfValid($attributes)
    {
        $streamer = Streamer::where('user_id', $attributes['user_id'])
            ->where('nickname', $attributes['nickname'])
            ->get()
            ->first();

        if($streamer) {
            return ['User already stored'];
        }

        $response_data = TwitchClient::instance()->clientRequest([
            'login' => $attributes['nickname'],
        ], 'users');

        if (!$response_data)
        {
            return ['Invalid twitch user'];
        }

        return [];
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

}
