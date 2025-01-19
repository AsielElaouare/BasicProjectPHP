<?php
namespace App\Services;

use App\Repositories\TweetRepository;

class TweetService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new TweetRepository();
    }

    public function getAllTweets()
    {
        return $this->repository->getAll();
    }
    
    public function getTweetBySlug($slug)
    {
        return $this->repository->getTweetBySlug($slug);
    }

    public function createTweet($userId, $content, $image)
    {
        if (empty($content)) {
            return false; 
        }
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $content))) . '-' . uniqid();

        return $this->repository->insert($userId, $content, $slug, $image);
    }

    public function getTweetsByUserId($user_id){

        return $this->repository->getTweetsByUserId($user_id);
    }

    public function deleteTweetById($tweetId){
        return $this->repository->deleteTweetById($tweetId);

    }
}
