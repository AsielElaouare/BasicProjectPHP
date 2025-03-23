<?php
namespace App\Repositories;

use PDO;

class CommentRepository extends Repository
{
    public function getCommentsByTweet($tweetId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM comments WHERE tweet_id = :tweet_id");
        $stmt->execute([':tweet_id' => $tweetId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'App\\Models\\Comment');
    }

    public function addComment($userId, $tweetId, $content)
    {
        $stmt = $this->connection->prepare("INSERT INTO comments (user_id, tweet_id, content, created_at) VALUES (:user_id, :tweet_id, :content, NOW())");
        return $stmt->execute([':user_id' => $userId, ':tweet_id' => $tweetId, ':content' => $content]);
    }
}
