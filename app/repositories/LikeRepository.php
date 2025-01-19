<?php
namespace App\Repositories;

use PDO;

class LikeRepository extends Repository
{
    public function addLike($userId, $tweetId)
    {
        $stmt = $this->connection->prepare("INSERT INTO likes (user_id, tweet_id) VALUES (:user_id, :tweet_id)");
        return $stmt->execute([':user_id' => $userId, ':tweet_id' => $tweetId]);
    }

    public function removeLike($userId, $tweetId)
    {
        $stmt = $this->connection->prepare("DELETE FROM likes WHERE user_id = :user_id AND tweet_id = :tweet_id");
        return $stmt->execute([':user_id' => $userId, ':tweet_id' => $tweetId]);
    }

    public function isLiked($userId, $tweetId)
    {
        $stmt = $this->connection->prepare("SELECT COUNT(*) FROM likes WHERE user_id = :user_id AND tweet_id = :tweet_id");
        $stmt->execute([':user_id' => $userId, ':tweet_id' => $tweetId]);
        return $stmt->fetchColumn() > 0;
    }
}
