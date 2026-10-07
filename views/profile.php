<?php

if (!isset($data)) {

    die("Profile data not found.");

}

?>

<!DOCTYPE html>

<html>

<head>

    <title>My Profile</title>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="../public/css/style.css">

</head>

<body>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card">

                <div class="card-header">

                    <h4>My Profile</h4>

                </div>

                <div class="card-body">

                    <?php if (!empty($message)) { ?>

                        <div class="alert alert-<?php echo htmlspecialchars($messageType); ?>">

                            <?php echo htmlspecialchars($message); ?>

                        </div>

                    <?php } ?>

                    <div class="text-center mb-4">

                        <?php if (!empty($data['profile_picture'])) { ?>

                            <img
                                src="../uploads/profile_pictures/<?php echo htmlspecialchars($data['profile_picture']); ?>"
                                alt="Profile Picture"
                                class="rounded-circle"
                                width="150"
                                height="150"
                                style="object-fit: cover;">

                        <?php } else { ?>

                            <div
                                class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto"
                                style="width:150px;height:150px;">

                                No Photo

                            </div>

                        <?php } ?>

                    </div>

                    <form
                        action="ProfileController.php"
                        method="POST"
                        enctype="multipart/form-data"
                        class="mb-4">

                        <div class="mb-3">

                            <label class="form-label">
                                Profile Picture
                            </label>

                            <input
                                type="file"
                                name="profile_picture"
                                class="form-control"
                                accept=".jpg,.jpeg,.png"
                                required>

                            <div class="form-text">
                                JPG, JPEG or PNG only. Maximum size: 2 MB.
                            </div>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            Upload Picture

                        </button>

                    </form>

                    <hr>

                    <p>
                        <strong>Name:</strong>
                        <?php echo htmlspecialchars($data['name']); ?>
                    </p>

                    <p>
                        <strong>NRIC:</strong>
                        <?php echo htmlspecialchars($data['icno']); ?>
                    </p>

                    <p>
                        <strong>Program:</strong>
                        <?php echo htmlspecialchars($data['program']); ?>
                    </p>

                    <p>
                        <strong>Marks:</strong>
                        <?php echo htmlspecialchars($data['marks']); ?>
                    </p>

                    <a
                        href="../views/change_password.php"
                        class="btn btn-warning">

                        Change Password

                    </a>

                    <a
                        href="../index.php"
                        class="btn btn-secondary">

                        Back

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>