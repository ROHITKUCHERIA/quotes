<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index() {
    try{
        $quote = [];
        for ($i = 1; $i <= 5; $i++) {
            $response = Http::get('https://api.kanye.rest');
            if ($response->successful()) {
                $quote[] = json_decode($response->body(), true)['quote'];
            }
        }
        $data['quote'] = $quote;
    }
    catch (\Exception $exception) {
        report($exception);
    }
    return view('home',$data);
    }
}
