<?php
use App\Models\User;
include __DIR__ . '/../header.php';
?>

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
            <h2 class="mb-0">Your Profile</h2>
        </div>
        <input id="user_id" type="text" value="<?php echo htmlspecialchars($user->id); ?>" hidden>
        <div class="card-body">
            <input type="text" value="" hidden>
            <?php if (isset($user)): ?>
                <div class="row">
                    <div class="col-md-3 text-center">
                        <?php if (!empty($user->profile_picture)): ?>
                            <img src="/uploads/user-pic/<?php echo htmlspecialchars($user->profile_picture); ?>" 
                                 alt="Profile Picture" 
                                 class="img-thumbnail rounded-circle mb-3"
                                 width="150" height="150">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center bg-light rounded-circle" 
                                 style="width: 150px; height: 150px;">
                                <span class="text-muted">No Image yet</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-9">
                        <h5 class="card-title mb-3">User Details</h5>
                        <p><strong>Username:</strong> <?php echo htmlspecialchars($user->username); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($user->email); ?></p>

                        <form action="/profile/uploadUserProfile" method="POST" enctype="multipart/form-data" class="mt-4">
                            <div class="form-group">
                                <label for="profile_picture" class="form-label">
                                    Upload a Profile Picture 
                                    <i class="fas fa-question-circle" data-bs-toggle="tooltip" 
                                       title="Choose a profile picture (JPG, PNG) less than 2MB."></i>
                                </label>
                                <input type="file" 
                                       class="form-control" 
                                       id="profile_picture" 
                                       name="profile_picture" 
                                       accept="image/*" 
                                       aria-describedby="fileHelp">
                                <small id="fileHelp" class="form-text text-muted">Maximum size: 2MB.</small>
                            </div>
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user->id); ?>">
                            <button type="submit" class="btn btn-success mt-3">Upload Picture</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    User not found.
                </div>
            <?php endif; ?>
        </div>
    </div>
    <h2 class="mt-4">Tweets you posted: </h2>
    <div id="posted-tweets-container" class=" mt-4"> </div>
</div>



<script>
    const userid = document.getElementById("user_id");
    fetch(`/api/controllers/postedtweetcontroller?user_id=${userid.value}`)
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => {
                throw new Error(`HTTP error! Status: ${response.status}, Response: ${text}`);
            });
        }
        const contentType = response.headers.get("Content-Type");
        if (contentType && contentType.includes("application/json")) {
            return response.json(); 
        } else {
            return response.text();
        }
    })
    .then(data => {
        console.log('Output: ', data);
        displayData(data);
    })
    .catch(err => {
        console.error('Fetch error:', err);
    });

    function displayData(tweets) {
    const container = document.getElementById("posted-tweets-container");

    container.innerHTML = '';

    tweets.forEach(tweet => {
        // Create a new card for each tweet
        const tweetCard = document.createElement("a");
        tweetCard.classList.add("card", "mb-3", "tex-reset", "text-decoration-none"); 
        tweetCard.setAttribute("href", `SingleTweet/show?slug=${tweet.slug}`);

        // Create card body
        const cardBody = document.createElement("div");
        cardBody.classList.add("card-body");

        // Add username
        const username = document.createElement("h5");
        username.classList.add("card-title");
        username.textContent = `@${tweet.username}`;
        cardBody.appendChild(username);

        // Add tweet content
        const content = document.createElement("p");
        content.classList.add("card-text");
        content.textContent = tweet.content;
        cardBody.appendChild(content);

        // Add created at date
        const createdAt = document.createElement("p");
        createdAt.classList.add("text-muted", "small");
        createdAt.textContent = `Posted on: ${new Date(tweet.created_at).toLocaleString()}`;
        cardBody.appendChild(createdAt);

        // Add image if available
        if (tweet.image) {
            const image = document.createElement("img");
            image.src = tweet.image;
            image.alt = "Tweet Image";
            image.classList.add("img-fluid", "mt-2");
            cardBody.appendChild(image);
        }

        // Add likes count
        const likes = document.createElement("p");
        likes.classList.add("card-text", "text-muted");
        likes.textContent = `${tweet.likes_count} likes`;
        cardBody.appendChild(likes);

        // Add a delete button
        const deleteButton = document.createElement("button");
        deleteButton.classList.add("btn", "btn-danger", "mt-2");
        deleteButton.textContent = "Delete";
        deleteButton.onclick = () => deleteTweet(tweet.id);
        
        // Add event listener to delete tweet on click
        deleteButton.addEventListener("click", function(event) {
            event.preventDefault();  // Prevent navigating to the tweet's page
            deleteTweet(tweet.id);   // Call deleteTweet with the tweet ID
        });

        // Append delete button to card body
        cardBody.appendChild(deleteButton);

        tweetCard.appendChild(cardBody);

        container.appendChild(tweetCard);
    });
}


function deleteTweet(tweetId) {
    fetch('/api/controllers/postedtweetcontroller/deleteTweet', {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            tweet_id: tweetId,
        }),
    })
    .then((response) => {
        // Always parse the response as text
        return response.text().then((text) => {
            console.log("Raw Response:", text); // Log the raw response text
            return { raw: text, status: response.status, headers: response.headers };
        });
    })
    .then(({ raw, status }) => {
        // Process the response as needed
        console.log("HTTP Status:", status);
        if (status >= 200 && status < 300) {
            console.log("Tweet deleted successfully (text response):", raw);
            location.reload();
        } else {
            console.error("Error occurred:", raw);
        }
    })
    .catch((error) => {
        console.error("Error deleting the tweet:", error.message || error);
    });
}

</script>

<?php include __DIR__ . '/../footer.php'; ?>
