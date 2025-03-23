<?php
namespace App\Repositories;

use PDO;
use App\Models\User;

class UserRepository extends Repository
{
    public function insert($username, $email, $password)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO users (username, email, password, created_at) 
                                                VALUES (:username, :email, :password, :created_at)");
            return $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => md5($password),
                ':created_at' => null,
            ]);
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function findByEmail($email)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function findByUsername($username)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function authenticate($email, $password)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
            $stmt->execute([':email' => $email, ':password' => md5($password)]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function getUserById(int $userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $userId]);

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'App\\Models\\User');
            $user = $stmt->fetch();
            
            return $user;
        } catch (\PDOException $e) {
            error_log($e->getMessage());

            return null;
        }
    }
    
    public function updateProfilePicture(int $userId, string $fileName): bool
    {
        try {
            $stmt = $this->connection->prepare("UPDATE users SET profile_picture = :profile_picture WHERE id = :id");
            return $stmt->execute([
                ':profile_picture' => $fileName,
                ':id' => $userId,
            ]);
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function updateUserInfo(int $userId, $userName, $email)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE users SET username = :userName, email = :email WHERE id = :id");
            return $stmt->execute([
                ':email' => $email,
                ':userName' => $userName,
                ':id' => $userId,
            ]);
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
