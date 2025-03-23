<?php
namespace App\Api\Controllers;

use App\Services\TweetService;

class PostedTweetController
{
    private $tweetService;

    public function __construct()
    {
        $this->tweetService = new TweetService();
    }

    public function index()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET['user_id'])) {
                try {

                    $tweets = $this->tweetService->getTweetsByUserId($_GET['user_id']);
                    header("Content-Type: application/json");
                    echo json_encode($tweets);
                } catch (Exception $e) {

                    http_response_code(400);
                    echo json_encode([
                        "error" => "Invalid userId: " . $e->getMessage()
                    ]);
                }
            } else {
                http_response_code(400); 
                echo json_encode(["error" => "No userId given."]);
            }
        } else {
            http_response_code(405); 
            echo json_encode(["error" => "Invalid HTTP method."]);
        }
    }

    
    
    
}