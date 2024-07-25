<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class ThingSpeakController extends Controller
{
    public function showData()
    {
        $apiKey = 'YOUR_READ_API_KEY';
        $channelId = 'YOUR_CHANNEL_ID';
        $url = "https://thingspeak.com/channels/2590205/charts/1?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&title=PM2.5&type=line ";

        $client = new Client();
        $response = $client->get($url);
        $data = json_decode($response->getBody(), true);

        $latestFeed = $data['feeds'][0];
        $feed = [
            'field1' => $latestFeed['field1'],
            'field2' => $latestFeed['field2'],
            'field3' => $latestFeed['field3'],
            'field4' => $latestFeed['field4'],
            'field5' => $latestFeed['field5'],
            'field6' => $latestFeed['field6'],
            'field7' => $latestFeed['field7'],
        ];

        // Ambil data profil pengguna
        $user = Auth::user();

        return view('thingspeak', compact('feed', 'user'));
    }
}
