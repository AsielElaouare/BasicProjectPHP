<?php
namespace App\Controllers;

use App\Services\UserService;

class RegisterController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function show()
    {
        if(isset($_SESSION["user_id"])){
            header('Location: /');
            exit();
        }
        require __DIR__ . '/../views/register/registerUser.php';
    }

    public function store()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];

        $message = $this->userService->register($username, $email, $password);

        if ($message === 'User registered successfully') {
            // Store user data in session
            $_SESSION['user_id'] = $message->id;         
            $_SESSION['username'] = $message->username;  
            $_SESSION['email'] = $message->email;        
            
            header('Location: /');
            exit();
        }
        require __DIR__ . '/../views/register/registerUser.php';
    }
}

}
