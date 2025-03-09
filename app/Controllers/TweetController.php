<?php
namespace App\Controllers;

use App\Services\TweetService;

class TweetController
{
    private $tweetService;

    public function __construct()
    {
        $this->tweetService = new TweetService();  
    }

     public function create()
     {
         require __DIR__ . '/../views/tweets/createTweet.php';
     }
 
     public function store()
     {
         if (!isset($_SESSION['user_id'])) {
             header('Location: /login');
             exit();
         }
 
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $content = htmlspecialchars($_POST['content']);
             $userId = $_SESSION['user_id'];
             $image = null;
 
             if (!empty($_FILES['image']['name'])) {
                 $targetDir = __DIR__ . '/.././public/uploads/tweet-imgs/';
                 $imageName = time() . '_' . basename($_FILES['image']['name']);
                 $targetFile = $targetDir . $imageName;
 
                 if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                     $image = '/uploads/tweet-imgs/' . $imageName;
                 }
             }
 
             $result = $this->tweetService->createTweet($userId, $content, $image);
 
             if ($result) {
                 header('Location: /');
                 exit();
             } else {
                 echo "Failed to post the tweet.";
             }
        }

    }
    
}
