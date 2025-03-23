<?php

namespace App\Api\Controllers;

use App\Services\TweetService;
use Throwable;

class DeleteTweetController{

    private TweetService $tweetService;

    public function __construct(){
        $this->tweetService = new TweetService();
    }

    public function delete()
    {
        header("Content-Type: application/json");
    
        try {
            if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
                $input = json_decode(file_get_contents("php://input"), true);
    
                if (isset($input['tweet_id']) && is_numeric($input['tweet_id'])) {
                    $tweetId = (int) $input['tweet_id'];
    
                    $this->tweetService->deleteTweetById($tweetId);
    
                    echo json_encode([
                        "status" => "success",
                        "message" => "Tweet deleted successfully",
                    ]);
                    return;
                } else {
                    http_response_code(400);
                    echo json_encode([
                        "status" => "error",
                        "message" => "Invalid or missing tweet_id",
                    ]);
                    return;
                }
            } else {
                http_response_code(405);
                echo json_encode([
                    "status" => "error",
                    "message" => "Invalid request method",
                ]);
                return;
            }
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage(),
                "file" => $e->getFile(),
                "line" => $e->getLine(),
            ]);
            return;
        }
    }
}