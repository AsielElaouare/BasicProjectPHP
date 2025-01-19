<?php
namespace App\Repositories;

use PDO;

class TweetRepository extends Repository
{

    public function getAll()
    {
    $stmt = $this->connection->prepare("
        SELECT 
        tweets.*, 
        users.username, 
        users.profile_picture, 
        (SELECT COUNT(*) FROM likes WHERE likes.tweet_id = tweets.id) AS likes_count
    FROM tweets 
    JOIN users ON tweets.user_id = users.id 
    ORDER BY tweets.created_at DESC;
    ");

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($userId, $content, $slug, $image)
    {
        $stmt = $this->connection->prepare(
            "INSERT INTO tweets (user_id, content, slug, image) VALUES (:user_id, :content, :slug, :image)"
        );

        return $stmt->execute([
            ':user_id' => $userId,
            ':content' => $content,
            ':slug' => $slug,
            ':image' => $image
        ]);
    }

    public function getTweetBySlug($slug)
{
    $stmt = $this->connection->prepare("
        SELECT 
            tweets.*, 
            users.username, 
            users.profile_picture, 
            (SELECT COUNT(*) FROM likes WHERE likes.tweet_id = tweets.id) AS likes_count
        FROM tweets
        JOIN users ON tweets.user_id = users.id
        WHERE tweets.slug = :slug
        LIMIT 1
    ");
    $stmt->execute([':slug' => $slug]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    private function generateUniqueSlug($content)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $content), '-'));

        $stmt = $this->connection->prepare("SELECT COUNT(*) FROM tweets WHERE slug = :slug");
        $count = 0;

        do {
            $stmt->execute([':slug' => $slug]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $slug = $slug . '-' . rand(1000, 9999);
            }
        } while ($count > 0);

        return $slug;
    }

    public function getTweetsByUserId($user_id){
        $stmt = $this->connection->prepare("
        SELECT 
            tweets.*, 
            users.username, 
            (SELECT COUNT(*) FROM likes WHERE likes.tweet_id = tweets.id) AS likes_count
        FROM tweets
        JOIN users ON tweets.user_id = users.id
        WHERE tweets.user_id = :user_id
        ");

        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteTweetById($tweetId)
    {
        $stmt = $this->connection->prepare("DELETE FROM tweets WHERE id = :tweetId");
        $stmt->execute([':tweetId' => $tweetId]);
    }
    
}
