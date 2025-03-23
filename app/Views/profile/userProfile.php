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
                        <div class="form-group">
                            <label for="username"><strong>Username:</strong></label>
                            <input type="text" id="username" class="form-control" value="<?php echo htmlspecialchars($user->username); ?>">
                        </div>
                        <div class="form-group">
                            <label for="email"><strong>Email:</strong></label>
                            <input type="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user->email); ?>">
                        </div>

                        <button id="updateProfileButton" class="btn btn-success mt-3">Update Profile</button>

                        <form action="/profile/uploadUserProfile" method="POST" enctype="multipart/form-data" class="mt-4">
                            <div class="form-group">
                                <label for="profile_picture" class="form-label">
                                    Upload a Profile Picture 
                                    <i class="fas fa-question-circle" data-bs-toggle="tooltip" 
                                       title="Choose a profile picture (JPG, PNG) less than 2MB."></i>
                                </label>
                                <input type="file" 
                                       id="fileInput"
                                       class="form-control" 
                                       id="profile_picture" 
                                       name="profile_picture" 
                                       accept="image/*" 
                                       aria-describedby="fileHelp">
                                <small id="fileHelp" class="form-text text-muted">Maximum size: 2MB.</small>
                            </div>
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user->id); ?>">
                            <button id="buttonFileInput" type="submit" class="btn btn-success mt-3">Upload Picture</button>
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
    <div id="posted-tweets-container" class=" mt-4"> 
        <span id="no-posted-tweets-alert" hidden class="alert alert-danger">No posted Tweets yet</span>
    </div>
</div>

<script src="/js/delete-tweet.js"></script>
<script src="/js/update-profile.js"></script>
<?php include __DIR__ . '/../footer.php'; ?>
