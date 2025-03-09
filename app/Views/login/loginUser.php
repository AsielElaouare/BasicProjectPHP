<?php include __DIR__ . '/../header.php'; ?>

<div class="container w-50 card shadow mt-5">
    <h1 class="my-4 text-center">Login</h1>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

   
    <form class="p-4 m-4" action="/login/authenticate" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Login</button>
    </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
