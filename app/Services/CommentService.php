<?php
namespace App\Services;

use App\Repositories\CommentRepository;

class CommentService
{
    private $commentRepository;

    public function __construct()
    {
        $this->commentRepository = new CommentRepository();
    }

    public function getCommentsByTweet($tweetId)
    {
        return $this->commentRepository->getCommentsByTweet($tweetId);
    }

    public function addComment($userId, $tweetId, $content)
    {
        $success = $this->commentRepository->addComment($userId, $tweetId, $content);
        return ['success' => $success];
    }
}
