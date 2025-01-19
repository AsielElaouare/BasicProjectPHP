<?php include __DIR__ . '/../header.php'; ?>

<div class="container mt-4">
    <!-- Post Tweet Button -->
    <div class="d-flex justify-content-end mb-4">
        <a href="/tweet" class="btn btn-success btn-lg">+ Post a Tweet</a>
    </div>

    <!-- Tweets List -->
    <?php if (!empty($tweets)): ?>
        <?php foreach ($tweets as $tweet): ?>
            <div class="card mb-4 mx-auto shadow-sm" style="max-width: 600px;">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <img 
                        src="<?php echo htmlspecialchars(
                            !empty($tweet['profile_picture']) 
                                ? '/uploads/user-pic/' . $tweet['profile_picture'] 
                                : '/uploads/user-pic/default.jpg'
                        ); ?>" 
                        alt="Profile Picture" 
                        class="rounded-circle me-3" 
                        width="50" 
                        height="50">
                        <div>
                            <h5 class="card-title mb-0">
                                <strong><?php echo htmlspecialchars($tweet['username']); ?></strong>
                            </h5>
                        </div>
                    </div>

                    <p class="card-text mt-2"><?php echo htmlspecialchars($tweet['content']); ?></p>

                    <?php if (!empty($tweet['image'])): ?>
                        <div class="tweet-image text-center my-3">
                            <img src="<?php echo htmlspecialchars($tweet['image']); ?>" 
                                 alt="Tweet Image" 
                                 class="img-fluid rounded" 
                                 style="max-width: 100%; height: auto;">
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <a href="/SingleTweet/show?slug=<?php echo htmlspecialchars($tweet['slug']); ?>" class="btn btn-primary btn-sm">
                            View Comments
                        </a>
                        <button 
                            class="btn btn-outline-danger btn-sm d-flex align-items-center like-btn" 
                            data-tweet-id="<?php echo htmlspecialchars($tweet['id']); ?>"
                        >
                            <i class="bi bi-heart me-1"></i> 
                            <span class="like-count"><?php echo htmlspecialchars($tweet['likes_count']); ?></span> Likes
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info text-center">
            <p class="mb-0">No tweets available. Be the first to post!</p>
        </div>
    <?php endif; ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $('.like-btn').on('click', function() {
            var tweetId = $(this).data('tweet-id'); 
            var likeButton = $(this); 
            var likeCountSpan = likeButton.find('.like-count');

            $.ajax({
                url: '/like', 
                method: 'POST',
                data: {
                    tweet_id: tweetId 
                },
                success: function(response) {
                    if (response.success) {
                        var newLikeCount = response.new_like_count;
                        likeCountSpan.text(newLikeCount); 
                    } else {
                        alert('You have already liked this tweet.');
                    }
                },
                error: function() {
                    alert('Error occurred while liking the tweet.');
                }
            });
        });
    });
</script>


<?php include __DIR__ . '/../footer.php'; ?>
