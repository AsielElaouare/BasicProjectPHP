$(document).ready(function() {
    $('#comment-form').on('submit', function(e) {
        e.preventDefault();  
        
        var content = $('#comment-content').val();
        var tweetId = $("#tweet-id").val();
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