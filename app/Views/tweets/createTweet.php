<?php include __DIR__ . '/../header.php'; ?>
<div class="container mt-5">
    <h1>Create a Tweet</h1>
    
    <?php if (!isset($_SESSION['user_id'])): ?>
        <p class="alert alert-warning">You need to be logged in to post a tweet.</p>
    <?php else: ?>
        <form action="/tweet/store" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="content" class="form-label">Tweet Content</label>
                <textarea name="content" id="content" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Optional Image</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Post Tweet</button>
        </form>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
