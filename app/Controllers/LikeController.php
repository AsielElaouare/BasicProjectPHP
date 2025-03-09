<?php
namespace App\Controllers;

use App\Services\LikeService; 

class LikeController
{
    private $likeService;

    public function __construct()
    {
        $this->likeService = new LikeService();
    }

    public function likeTweet()
    {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tweetId = $_POST['tweet_id'];
            $userId = $_SESSION['user_id'];

            $result = $this->likeService->likeTweet($userId, $tweetId);

            if ($result['success']) {
                echo json_encode(['success' => true, 'new_like_count' => $result['new_like_count']]);
            } else {
                
                echo json_encode(['success' => false, 'message' => 'Already liked']);
            }
        }
    }
}

