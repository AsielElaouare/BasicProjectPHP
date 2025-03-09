<?php
namespace App\Repositories;

use PDO;
use App\Models\User;

class UserRepository extends Repository
{
    public function insert($username, $email, $password )
    {
        $stmt = $this->connection->prepare("INSERT INTO users (username, email, password, created_at) 
                                            VALUES (:username, :email, :password, :created_at)");
        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => md5($password),
            ':created_at' => null,
        ]);
    }

    public function findByEmail($email)
    {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function findByUsername($username)
    {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function authenticate($email, $password)
    {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
        $stmt->execute([':email' => $email, ':password' => md5($password)]); 
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getUserById($userId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $userId]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'App\\Models\\User');
        $user = $stmt->fetch();
        
        return $user;
    }
    
    public function updateProfilePicture(int $userId, string $fileName): bool
    {
        $stmt = $this->connection->prepare("UPDATE users SET profile_picture = :profile_picture WHERE id = :id");

        return $stmt->execute([
            ':profile_picture' => $fileName,
            ':id' => $userId,
        ]);
    }
}
