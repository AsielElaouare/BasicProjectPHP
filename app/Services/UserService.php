<?php
namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;

class UserService
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function register($username, $email, $password)
    {
        if ($this->userRepository->findByEmail($email)) {
            return 'Email already exists';
        }

        if ($this->userRepository->findByUsername($username)) {
            return 'Username already exists';
        }

        if ($this->userRepository->insert($username, $email, $password )) {
            return $this->login($email, $password);
        }

        return 'Error during registration';
    }
    
    public function login($email, $password)
    {
        $user = $this->userRepository->authenticate($email, $password);
        if ($user) {
            return $user;
        }

        return 'Invalid credentials';
    }
    
    public function getUserById($userId)
    {
        return $this->userRepository->getUserById($userId);
    }

    public function updateProfilePicture(int $userId, string $fileName): bool
    {
        if (empty($userId) || empty($fileName)) {
            return false;
        }
        return $this->userRepository->updateProfilePicture($userId, $fileName);
    }

    public function updateProfile(int $userId, string $username, string $email): bool
    {
        if (empty($userId)) {
            return false;
        }
        return $this->userRepository->updateUserInfo($userId, $username, $email);
    }
}