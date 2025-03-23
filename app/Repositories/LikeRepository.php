<?php
namespace App\Repositories;

use PDO;
use PDOException;

class LikeRepository extends Repository
{
    public function addLike($userId, $tweetId)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO likes (user_id, tweet_id) VALUES (:user_id, :tweet_id)");
            return $stmt->execute([':user_id' => $userId, ':tweet_id' => $tweetId]);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function removeLike($userId, $tweetId)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM likes WHERE user_id = :user_id AND tweet_id = :tweet_id");
            return $stmt->execute([':user_id' => $userId, ':tweet_id' => $tweetId]);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function isLiked($userId, $tweetId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT COUNT(*) FROM likes WHERE user_id = :user_id AND tweet_id = :tweet_id");
            $stmt->execute([':user_id' => $userId, ':tweet_id' => $tweetId]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getLikesByTweetId($tweetId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT COUNT(*) FROM likes WHERE tweet_id = :tweet_id");
            $stmt->execute([':tweet_id' => $tweetId]);
            return $stmt->fetchColumn(); 
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
