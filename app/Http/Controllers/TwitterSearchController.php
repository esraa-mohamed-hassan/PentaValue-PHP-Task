<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Job;
use App\Models\Project;
use App\Models\Task;
use TwitterAPIExchange;
use Illuminate\Http\Request;

class TwitterSearchController extends Controller
{
    public function search(Request $request)
    {
       
        // $query = $request->input('query');

        // $twitter = new TwitterAPIExchange([
        //     'oauth_access_token' => env('TWITTER_ACCESS_TOKEN'),
        //     'oauth_access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),
        //     'consumer_key' => env('TWITTER_CONSUMER_KEY'),
        //     'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
        // ]);
        
        // $url = 'https://api.twitter.com/1.1/search/tweets.json';
        // $requestMethod = 'GET';
        // $getfield = '?q=' . urlencode($query) . '&count=10';

        // $response = $twitter->setGetfield($getfield)
        //                     ->buildOauth($url, $requestMethod)
        //                     ->performRequest();

        // $tweets = json_decode($response, true);
        // dd($tweets );
        // // Process and display the search results
        // return view('twitter.search', ['tweets' => $tweets['statuses']]);
    }
}






