<?php
namespace App\Controllers;

use App\Services\TweetService;
use App\Services\CommentService;

class SingleTweetController
{
    private $tweetService;
    private $commentService;

    public function __construct()
    {
        $this->tweetService = new TweetService();
        $this->commentService = new CommentService();
    }

    public function show()
    {
    if (isset($_GET['slug'])) {
        $slug = $_GET['slug']; 
    } else {
        echo "404 - Not Found";
        exit;
    }

    $tweet = $this->tweetService->getTweetBySlug($slug);
    if (!$tweet) {
        echo "404 - Tweet not found";
        exit;
    }

    $comments = $this->commentService->getCommentsByTweet($tweet['id']);

    require __DIR__ . '/../views/singleTweet/tweet.php';
}

}
