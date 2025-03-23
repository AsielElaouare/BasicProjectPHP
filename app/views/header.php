<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Twitter Clone</title>
</head>
<body class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-white min-h-screen">

<nav class="w-full bg-gradient-to-r from-gray-600 via-gray-800 to-gray-900 bg-opacity-60 backdrop-blur-lg shadow-lg py-4 z-50">
    <div class="container mx-auto flex justify-between items-center px-6">
        <a href="/" class="text-2xl font-bold text-white">Home</a>
        <ul class="flex space-x-6 items-center">
            <?php if (isset($_SESSION['user_id'])): ?>
                <li>
                    <div class="flex items-center space-x-2">
                    <img class="w-8 h-8 rounded-full object-cover" 
                        src="/uploads/user-pic/<?= !empty($_SESSION['profile_pic']) ? htmlspecialchars($_SESSION['profile_pic']) : 'default.png' ?>" 
                         alt="Profile Picture">
                        <a href="/profile" class="text-gray-300 hover:text-blue-400 transition">Profile</a>
                    </div>
                </li>
                <li><a href="/logout" class="text-gray-300 hover:text-red-400 transition">Logout</a></li>
            <?php else: ?>
                <li><a href="/login" class="text-gray-300 hover:text-green-400 transition">Login</a></li>
                <li><a href="/register" class="text-gray-300 hover:text-yellow-400 transition">Register</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="mt-4 container ">
