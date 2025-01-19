<?php
namespace App\Controllers;

use App\Services\UserService;

class LoginController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function show()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit();
        }

        require __DIR__ . '/../views/login/loginUser.php';
    }

    public function authenticate()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = htmlspecialchars($_POST['email']);
            $password = $_POST['password'];

            $user = $this->userService->login($email, $password);

            if (is_object($user)) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                header('Location: /');
                exit();
            }
            $error = $user;
            require __DIR__ . '/../views/login/loginUser.php';
        }
    }

    public function logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];

        session_destroy();

        header("Location: /login");
        exit();
    }
}
