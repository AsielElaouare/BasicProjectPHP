const fileInput = document.getElementById("fileInput");
const buttonFileInput = document.getElementById("buttonFileInput");
const noPostedTweeets = document.getElementById("no-posted-tweets-alert");
buttonFileInput.disabled = true;

fileInput.addEventListener("change", function () {
    if (fileInput.files.length != 0) {
        buttonFileInput.disabled = false;
    }
});

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
    if(data.length != 0){
        displayData(data);
        
    }else{
        noPostedTweeets.hidden = false;
    }
})
.catch(err => {
    console.error('Fetch error:', err);
});

function displayData(tweets) {
const container = document.getElementById("posted-tweets-container");

container.innerHTML = '';

tweets.forEach(tweet => {
    const tweetCard = document.createElement("a");
    tweetCard.classList.add("card", "mb-3", "tex-reset", "text-decoration-none"); 
    tweetCard.setAttribute("href", `SingleTweet/show?slug=${tweet.slug}`);

    const cardBody = document.createElement("div");
    cardBody.classList.add("card-body");

    const username = document.createElement("h5");
    username.classList.add("card-title");
    username.textContent = `@${tweet.username}`;
    cardBody.appendChild(username);

    const content = document.createElement("p");
    content.classList.add("card-text");
    content.textContent = tweet.content;
    cardBody.appendChild(content);

    const createdAt = document.createElement("p");
    createdAt.classList.add("text-muted", "small");
    createdAt.textContent = `Posted on: ${new Date(tweet.created_at).toLocaleString()}`;
    cardBody.appendChild(createdAt);

    if (tweet.image) {
        const image = document.createElement("img");
        image.src = tweet.image;
        image.alt = "Tweet Image";
        image.classList.add("img-fluid", "mt-2");
        cardBody.appendChild(image);
    }

    const likes = document.createElement("p");
    likes.classList.add("card-text", "text-muted");
    likes.textContent = `${tweet.likes_count} likes`;
    cardBody.appendChild(likes);

    const deleteButton = document.createElement("button");
    deleteButton.classList.add("btn", "btn-danger", "mt-2");
    deleteButton.textContent = "Delete";
    deleteButton.onclick = () => deleteTweet(tweet.id);
    
    deleteButton.addEventListener("click", function(event) {
        event.preventDefault();  
        deleteTweet(tweet.id);   
    });

    cardBody.appendChild(deleteButton);

    tweetCard.appendChild(cardBody);

    container.appendChild(tweetCard);
});
}

function deleteTweet(tweetId) {
    fetch('/api/controllers/deletetweet', {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            tweet_id: tweetId,
        }),
    })
    .then((response) => {

        
        return response.text().then((text) => {
            console.log("Raw Response:", text);
            return { raw: text, status: response.status, headers: response.headers };
        });
    })
    .then(({ raw, status }) => {
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
