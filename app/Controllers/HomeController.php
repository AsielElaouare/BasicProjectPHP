<?php
namespace App\Controllers;
use App\Services\TweetService;

class HomeController
{
    private $tweetService;

    public function __construct()
    {
        $this->tweetService = new TweetService();
    }

    public function index()
    {
        $tweets = $this->tweetService->getAllTweets();
        require __DIR__ . '/../views/tweets/index.php';
    }
}