document.getElementById("updateProfileButton").addEventListener("click", function(event) {
    event.preventDefault();

    var userId = document.getElementById("user_id").value;
    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;

    var data = {
        user_id: userId,
        username: username,
        email: email
    };

    fetch('/profile/updateProfile', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data),
        dataType: "json",
    })
    .then(response => response.json())
    .then(responseData => {
        if (responseData.status === 'success') {
            document.querySelector("#username").textContent = username;
            document.querySelector("#email").textContent = email;

            alert("Profile updated successfully!");
        } else {
            alert("Failed to update profile: " + responseData.message);
        }
    })
    .catch(error => {
        alert("An error occurred: " + error.message);
    });
});