<?php

namespace App\Controllers;

use App\Services\CommentService;

class CommentController
{
    private $commentService;

    public function __construct()
    {
        $this->commentService = new CommentService();
    }

    public function store()
    {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'You need to be logged in to comment.']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $tweetId = $_POST['tweet_id'];
            $content = htmlspecialchars($_POST['content']);

            $result = $this->commentService->addComment($userId, $tweetId, $content);
            http_response_code(200);

            echo json_encode(["message" => "OK"]);
        }
    }
}
