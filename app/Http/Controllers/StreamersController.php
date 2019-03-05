<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Streamer;

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

        $client = new \GuzzleHttp\Client();
        // dd(env('TWITCH_KEY'));
        $request = $client->request('GET', 'https://api.twitch.tv/helix/videos', [
            'headers' => ['Client-ID' => env('TWITCH_KEY')],
            'query' => ['id' => '388692160'],
        ]);
        // dd(json_decode($request->getBody()->getContents()));
        // dd($response = $request->getBody()->getContents());

        return view('streamers.index', compact('streamers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $client = new \GuzzleHttp\Client();
        $request = $client->request('GET', 'https://api.twitch.tv/helix/users', [
            'headers' => ['Client-ID' => env('TWITCH_KEY')],
            'query' => ['login' => $attributes['nickname']],
        ]);

        if ($request->getStatusCode() === 200) {
            $response = json_decode($request->getBody()->getContents());
            $attributes['twitch_id'] = $response->data[0]->id;

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
        abort_if($streamer->user_id !== auth()->id(), 403);

        $videos = [];

        $client = new \GuzzleHttp\Client();
        $request = $client->request('GET', 'https://api.twitch.tv/helix/videos', [
            'headers' => ['Client-ID' => env('TWITCH_KEY')],
            'query' => [
                'user_id' => $streamer->twitch_id,
                'first' => 10,
            ],
        ]);

        if ($request->getStatusCode() === 200) {
            $response = json_decode($request->getBody()->getContents());
            $videos = $response->data;
        }

        return view('streamers.show', compact('streamer', 'videos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Streamer $streamer)
    {
        abort_if($streamer->user_id !== auth()->id(), 403);

        $streamer->delete();

        return redirect('/streamers');
    }

    protected function validateStreamer()
    {
        /*
        TODO:
            Check is a valid username on twitch.l
            Check if the streamer is already stored for the user.
        */

        return request()->validate([
            'nickname' => ['required', 'min:3'],
        ]);
    }
}
