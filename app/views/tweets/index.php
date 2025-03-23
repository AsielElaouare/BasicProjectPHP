<?php include __DIR__ . '/../header.php'; ?>

<div class="container mx-auto mt-6 px-4">
    <div class="flex justify-end mb-4">
        <a href="/tweet" class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600">+ Post a Tweet</a>
    </div>
</div>
<div class="container mx-auto mt-6 px-4">
    <?php if (!empty($tweets)): ?>
        <?php foreach ($tweets as $tweet): ?>
            <div class="bg-white shadow-md rounded-lg p-6 mb-6 max-w-lg mx-auto">
                <div class="flex items-center mb-4">
                    <img src="<?php echo htmlspecialchars(!empty($tweet['profile_picture']) ? '/uploads/user-pic/' . $tweet['profile_picture'] : '/uploads/user-pic/default.jpg'); ?>" 
                         alt="Profile Picture" 
                         class="w-12 h-12 rounded-full mr-4">
                    <h5 class="font-bold text-lg text-gray-800">
                        <?php echo htmlspecialchars($tweet['username']); ?>
                    </h5>
                </div>
                <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($tweet['content']); ?></p>
                <?php if (!empty($tweet['image'])): ?>
                    <div class="mb-4">
                        <img src="<?php echo htmlspecialchars($tweet['image']); ?>" 
                             alt="Tweet Image" 
                             class="rounded-lg w-25 mx-auto object-cover">
                    </div>
                <?php endif; ?>
                <div class="flex justify-between items-center">
                    <a href="/SingleTweet/show?slug=<?php echo htmlspecialchars($tweet['slug']); ?>" 
                       class="text-blue-500 hover:underline">View Comments</a>
                    <button class="flex items-center text-red-500 hover:text-red-600 like-btn" 
                            data-tweet-id="<?php echo htmlspecialchars($tweet['id']); ?>">
                        <i class="bi bi-heart-fill mr-2"></i>
                        <span class="like-count"><?php echo htmlspecialchars($tweet['likes_count']); ?></span> Likes
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="bg-blue-100 text-blue-700 text-center p-4 rounded-lg">
            <p>No tweets available. Be the first to post!</p>
        </div>
    <?php endif; ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/js/like.js"></script>
<?php include __DIR__ . '/../footer.php'; ?>
