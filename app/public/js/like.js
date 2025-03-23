$(document).ready(function() {
    $('.like-btn').on('click', function() {
        var tweetId = $(this).data('tweet-id'); 
        var likeButton = $(this); 
        var likeCountSpan = likeButton.find('.like-count');

        $.ajax({
            url: '/like/liketweet', 
            method: 'POST',
            data: {
                tweet_id: tweetId 
            },
            dataType: "json",
            success: function(response) {
                    likeCountSpan.text(response.new_like_count);  
            },
            error: function() {
                alert('Error occurred while liking the tweet.');
            }
        });
    });
});