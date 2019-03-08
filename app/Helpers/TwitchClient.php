<?php
namespace App\Helpers;

class TwitchClient
{
    protected $client, $headers;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
        $this->headers = ['Client-ID' => env('TWITCH_KEY')];
    }

    public function clientRequest($query, $resource)
    {
        $request = $this->client->request('GET', env('TWITCH_API_URI') . $resource, [
            'headers' => $this->headers,
            'query' => $query,
        ]);

        if ($request->getStatusCode() === 200) {
            $response = json_decode($request->getBody()->getContents());
            return $response->data;
        }

        return false;
    }

    public static function instance()
    {
         return new TwitchClient();
    }

}
