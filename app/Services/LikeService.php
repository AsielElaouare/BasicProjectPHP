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
        $newLikeCount = 0;  
        
        if ($this->likeRepository->isLiked($userId, $tweetId)) {
            $this->likeRepository->removeLike($userId, $tweetId);
            $newLikeCount = $this->likeRepository->getLikesByTweetId($tweetId);
            return ['success' => true, 'new_like_count' => $newLikeCount];
        } else {
            $this->likeRepository->addLike($userId, $tweetId);
            $newLikeCount = $this->likeRepository->getLikesByTweetId($tweetId);
            return ['success' => true, 'new_like_count' => $newLikeCount];
        }
    }

    public function getTweetLikes($tweetId){
        $this->likeRepository->getLikesByTweetId($tweetId);
    }
}
