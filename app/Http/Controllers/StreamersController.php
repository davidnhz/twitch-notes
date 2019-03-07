<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use App\Streamer;

class StreamersController extends Controller
{
    protected $client, $headers;

    public function __construct()
    {
        $this->middleware('auth');

        $this->client = new \GuzzleHttp\Client();
        $this->headers = ['Client-ID' => env('TWITCH_KEY')];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $streamers = auth()->user()->streamers;

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

        if ($errors = $this->checkIfValid($attributes))
        {
            return redirect()->back()->withErrors($errors);
        }

        $request = $this->client->request('GET', env('TWITCH_API_URI') . 'users', [
            'headers' => $this->headers,
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
        $this->authorize('owns', $streamer);

        $videos = [];

        $request = $this->client->request('GET', env('TWITCH_API_URI') . 'videos', [
            'headers' => $this->headers,
            'query' => [
                'user_id' => $streamer->twitch_id,
                'first' => 10,
            ],
        ]);

        if ($request->getStatusCode() === 200) {
            $response = json_decode($request->getBody()->getContents());
            $videos = $response->data;

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
        /*
        TODO:
            Check is a valid username on twitch.
            Check if the streamer is already stored for current user.
        */
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

        $request = $this->client->request('GET', env('TWITCH_API_URI') . 'users', [
            'headers' => $this->headers,
            'query' => [
                'login' => $attributes['nickname'],
            ],
        ]);

        if ($request->getStatusCode() === 200) {
            $response = json_decode($request->getBody()->getContents());
            $twitch_user = $response->data;

            if (!$twitch_user)
            {
                return ['Invalid twitch user'];
            }
        }

        return [];
    }
}
