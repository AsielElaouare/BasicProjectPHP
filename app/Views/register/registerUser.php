<?php include __DIR__ . '/../header.php'; ?>

<div class="container card shadow mt-5 w-50">
    <h1 class="my-4 text-center">Register</h1>

    <?php if (isset($message)): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <form class="p-4 m-4 fw-bold" action="/register/store" method="POST">
        <div class="form-group mb-2">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label for="password">Password</label>
            <input id="password-input" type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label for="confirm-password">Confirm password</label>
            <input id="confirm-password-input" type="password" name="confirm-password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Register</button>
    </form>
</div>
<?php include __DIR__ . '/../footer.php'; ?>


<script>
    const passwordInput =document.getElementById("password-input");
    const confirmPasswordInput =document.getElementById("confirm-password-input");
    
    confirmPasswordInput.addEventListener("input", function () {
        if (passwordInput.value !== confirmPasswordInput.value) {
            confirmPasswordInput.setCustomValidity("Passwords do not match");
        } else {
            confirmPasswordInput.setCustomValidity("");
        }
    });

    document.querySelector("form").addEventListener("submit", function (event) {
        if (passwordInput.value !== confirmPasswordInput.value) {
            event.preventDefault();
            alert("Passwords do not match!");
        }
    });


</script>