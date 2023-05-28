<?php

namespace App\Http\Controllers;

use MongoDB\Client;
use Illuminate\Http\Request;
use TwitterAPIExchange;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class TwitterSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $mongoClient = new Client("mongodb://localhost:27017");
        $mongoDb = $mongoClient->selectDatabase('twitter_db');
        $tweetsCollection = $mongoDb->selectCollection('tweets');


        $twitter = new TwitterAPIExchange([
            'consumer_key' => env('TWITTER_CONSUMER_KEY'),
            'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
            'oauth_access_token' => env('TWITTER_ACCESS_TOKEN'),
            'oauth_access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),
        ]);

        // Fetch and store the top 10,000 results of a search from Twitter
        $this->fetchAndStoreTweets($query, 10000, $tweetsCollection, $twitter);

        // MongoDB connection for user information
        $usersCollection = $mongoDb->selectCollection('users');

        // Fetch and store user information for each unique user in the tweets collection
        $userIds = $tweetsCollection->distinct('useruid');
        foreach ($userIds as $userId) {
            $this->fetchAndStoreUserInfo($userId, $usersCollection, $twitter);
        }
    }

    public function fetchAndStoreTweets($searchWord, $count, $collection, $twitter)
    {
        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $getfield = "?q=$searchWord&count=$count";
        $requestMethod = 'GET';

        $tweets = json_decode($twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest(), true);

        foreach ($tweets['statuses'] as $tweet) {
            $tweetData = [
                'tweet' => $tweet['text'],
                'useruid' => $tweet['user']['id_str'],
                'datetime' => $tweet['created_at']
            ];

            $collection->insertOne($tweetData);
        }
    }


    public function fetchAndStoreUserInfo($userId, $collection, $twitter)
    {
        $url = "https://api.twitter.com/1.1/users/show.json";
        $getfield = "?user_id=$userId";
        $requestMethod = 'GET';

        $user = json_decode($twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest(), true);

        $userData = [
            'useruid' => $user['id_str'],
            'username' => $user['screen_name'],
            'followers' => $user['followers_count'],
            'location' => $user['location']
            // Add more user information fields as needed
        ];

        $collection->insertOne($userData);
    }

    public function connectFirebase()
    {
        // Firebase credentials (service account key)
        $serviceAccount = ServiceAccount::fromJsonFile('config/firebase_credentials.json');

        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();

        $firestore = $firebase->getFirestore();

        // Store the top 20 users in Firebase
        $this->storeTopUsers($usersCollection, $firestore);
    }

    // Function to store top 20 users in Firebase
    function storeTopUsers($usersCollection, $firestore)
    {
        $topUsers = $usersCollection->find([], ['sort' => ['followers' => -1], 'limit' => 20]);

        foreach ($topUsers as $user) {
            $userData = [
                'useruid' => $user['useruid'],
                'username' => $user['username'],
                'followers' => $user['followers'],
                'location' => $user['location']
                // Add more user information fields as needed
            ];

            $firestore->collection('top_users')->add($userData);
        }
    }
}
