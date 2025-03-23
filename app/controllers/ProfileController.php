<?php
namespace App\Controllers;

use App\Services\UserService;
use ReflectionFunctionAbstract;

class ProfileController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function show()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $user = $this->userService->getUserById($_SESSION['user_id']);
        require __DIR__ . '/../views/profile/userProfile.php';
    }

    public function uploadUserProfile(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture']) && isset($_POST['user_id'])) {
            $userId = intval($_POST['user_id']);
            $file = $_FILES['profile_picture'];
            
            if ($file['size'] > 2 * 1024 * 1024) {
                header('Location: /profile.php?error=File size exceeds 2MB');
                exit;
            }
            
            $allowedTypes = ['image/jpeg', 'image/png'];
            if (!in_array($file['type'], $allowedTypes)) {
                header('Location: /profile.php?error=Invalid file type. Only JPG and PNG allowed.');
                exit;
            }
            
            $uploadDir = __DIR__ . '/.././public/uploads/user-pic/';
            $fileName = uniqid() . '_' . basename($file['name']);
            $uploadFile = $uploadDir . $fileName;
        
            if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                $this->userService->updateProfilePicture($userId, $fileName); 
                $_SESSION['profile_pic'] = $fileName;
                header('Location: /profile');
            } else {
                header('Location: /profile.php?error=Error uploading file.');
            }
            exit;
        }
    }
   
    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $inputData = json_decode(file_get_contents('php://input'), true);
    
            if (isset($inputData['user_id']) && isset($inputData['username']) && isset($inputData['email'])) {
                $this->userService->updateProfile($_SESSION["user_id"], $inputData['username'], $inputData['email']);
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        }
    }
}
