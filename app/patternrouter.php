<?php
namespace app;

class PatternRouter
{
    private function stripParameters($uri)
    {
        if (str_contains($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        return $uri;
    }

    public function route($uri)
    {
        $uri = $this->stripParameters($uri);

        $explodedUri = explode('/', $uri);

        // Default controller and method
        if (!isset($explodedUri[0]) || empty($explodedUri[0])) {
            $explodedUri[0] = 'home';
        }
        // Determine controller and method
        $controllerName = "App\\Controllers\\" . ucfirst($explodedUri[0]) . "Controller";

        if (!isset($explodedUri[1]) || empty($explodedUri[1])) {
            $explodedUri[1] = 'index';
        }
        $methodName = $explodedUri[1];

        if ($uri === 'profile') {
            $controllerName = "App\\Controllers\\ProfileController";
            $methodName = 'show'; 
        }

        if ($uri === 'login') {
            $controllerName = "App\\Controllers\\LoginController";
            $methodName = 'show'; 
        }
        if ($uri === 'logout') {
            $controllerName = "App\\Controllers\\LoginController";
            $methodName = 'logout'; 
        }
        if ($uri === 'register') {
            $controllerName = "App\\Controllers\\RegisterController";
            $methodName = 'show'; 
        }
        if ($uri === 'like') {
            $controllerName = "App\\Controllers\\LikeController";
            $methodName = 'likeTweet'; 
        }
        if ($uri === 'tweet') {
            $controllerName = "App\\Controllers\\TweetController";
            $methodName = 'create'; 
        }
        if ($uri === 'comment') {
            $controllerName = "App\\Controllers\\CommentController";
            $methodName = 'store'; 
        }
        if (str_contains($uri, 'api/controllers/postedtweetcontroller')) {
            $controllerName = "App\\Api\\Controllers\\PostedTweetController";
            $methodName = 'index'; 
        }

        if ($uri === 'api/controllers/postedtweetcontroller/deleteTweet') {
            $controllerName = "App\\Api\\Controllers\\PostedTweetController";
            $methodName = 'delete'; 
        }

        
        if(!class_exists($controllerName) || !method_exists($controllerName, $methodName)) {
            http_response_code(404);
            return;
        }

        try {
            $controllerObj = new $controllerName();
            $controllerObj->$methodName();
        } catch(Error $e) {
            
            http_response_code(500);
        }
    }
}