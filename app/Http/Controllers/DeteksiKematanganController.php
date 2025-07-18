<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class DeteksiKematanganController extends Controller
{
    public function classifyBanana(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg',
        ]);

        $client = new Client();

        $response = $client->post('http://localhost:8000/predict', [ // http://ml_service:8000/predict -> jaga"
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen($request->file('image')->getPathname(), 'r'),
                    'filename' => $request->file('image')->getClientOriginalName(),
                ]
            ]
        ]);

        return response()->json(json_decode($response->getBody(), true));
    }
}
