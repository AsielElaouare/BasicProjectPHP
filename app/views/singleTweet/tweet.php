<?php
use App\Models\Tweet;
use App\Models\Comment;
include __DIR__ . '/../header.php';
?>

<div class="container my-5 w-75">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="mt-3 mb-3">
                <img src="<?php echo htmlspecialchars(!empty($tweet['profile_picture']) ? '/uploads/user-pic/' . $tweet['profile_picture'] : '/uploads/user-pic/default.jpg'); ?>" 
                alt="Profile Picture" class="rounded-circle" width="50" height="50">
                <span class="ms-2 h4 fw-bold"><?php echo htmlspecialchars($tweet['username']); ?></span>
            </div>
            <h5 class="card-title"><?php echo htmlspecialchars($tweet['content']); ?></h5>
            <div class="text-center mt-4">
            <?php
             if(!empty($tweet['image'])): ?>
                 <img src="<?php echo htmlspecialchars($tweet['image']); ?>"  class="img-fluid mb-3 " style="max-width: 100%; height: auto;">
            <?php endif; ?>
            </div>
            <div class="d-flex justify-content-between">
            <p class="card-text text-muted">
                <small>Posted on <?php echo date("Y-m-d H:i:s", strtotime($tweet['created_at'])); ?></small>
            </p>
            <button class="btn btn-outline-danger btn-sm d-flex align-items-center">
                            <i class="bi bi-heart me-1"></i><?php echo $tweet['likes_count'] ?? 0; ?> Likes</button>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h4 class="mb-3">Comments</h4>
        
        <?php if (empty($comments)): ?>
            <p class="alert alert-primary">No comments yet. Be the first to comment!</p>
        <?php else: ?>
            <div id="comments-list">
                <?php foreach ($comments as $comment): ?>
                    <div class="card mb-3 comment-item">
                        <div class="card-body">
                            <p class="card-text"><?php echo htmlspecialchars($comment->content); ?></p>
                            <p class="text-muted"><small>Commented by User #<?php echo htmlspecialchars($comment->user_id); ?> on <?php echo date("Y-m-d H:i:s", strtotime($comment->created_at)); ?></small></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_id'])): ?>
            <h5 class="mt-4">Add a Comment</h5>
            <form id="comment-form" method="POST" class="mt-2">
                <div class="form-group">
                    <textarea id="comment-content" name="content" class="form-control" rows="3" required placeholder="Write your comment here..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit Comment</button>
            </form>
        <?php else: ?>
            <p class="mt-3 text-danger">You need to be logged in to comment on this tweet.</p>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#comment-form').on('submit', function(e) {
            e.preventDefault();  
            
            var content = $('#comment-content').val();
            var tweetId = <?php echo $tweet['id']; ?>;
            var form = $(this);
            
            $.ajax({
                url: '/comment',  
                method: 'POST',
                data: {
                    tweet_id: tweetId,
                    content: content
                },
                success: function(response) {
                    if (response.success) {
                        var newComment = `
                            <div class="card mb-3 comment-item">
                                <div class="card-body">
                                    <p class="card-text">${response.content}</p>
                                    <p class="text-muted"><small>Commented by ${response.username} on ${response.created_at}</small></p>
                                </div>
                            </div>
                        `;
                        $('#comments-list').append(newComment);
                        $('#comment-content').val(''); 
                        location.reload();
                    } else {
                        location.reload();
                    }
                },
                error: function() {
                    alert('Error occurred while posting the comment.');
                }
            });
        });
    });
</script>
