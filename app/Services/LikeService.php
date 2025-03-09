<?php
namespace App\Services;

use App\Repositories\LikeRepository;

class LikeService
{
    private $likeRepository;

    public function __construct()
    {
        $this->likeRepository = new LikeRepository();
    }

    public function toggleLike($userId, $tweetId)
    {
        if ($this->likeRepository->isLiked($userId, $tweetId)) {
            // Unlike if already liked
            $this->likeRepository->removeLike($userId, $tweetId);
            return false; // Indicates the like was removed
        } else {
            // Add a like if not already liked
            $this->likeRepository->addLike($userId, $tweetId);
            return true; // Indicates the like was added
        }
    }
}
