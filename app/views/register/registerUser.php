<?php include __DIR__ . '/../header.php'; ?>

<div class="container card shadow mt-5 w-50">
    <h1 class="my-4 text-center">Register</h1>

    <?php if (isset($message)): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <form class="p-4 m-4" action="/register/store" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Register</button>
    </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
