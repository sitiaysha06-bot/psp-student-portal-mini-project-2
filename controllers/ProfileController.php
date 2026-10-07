<?php

session_start();

include '../config/database.php';
include '../models/User.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: ../views/login.php");
    exit;

}

$user = new User($conn);

$userId = $_SESSION['user_id'];
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_FILES['profile_picture'])) {

        $message = "Please select a profile picture.";
        $messageType = "danger";

    } else {

        $file = $_FILES['profile_picture'];

        if ($file['error'] !== UPLOAD_ERR_OK) {

            $message = "Failed to upload the file.";
            $messageType = "danger";

        } elseif ($file['size'] > 2 * 1024 * 1024) {

            $message = "File size must not exceed 2 MB.";
            $messageType = "danger";

        } else {

            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $allowedMimeTypes = ['image/jpeg', 'image/png'];

            $extension = strtolower(
                pathinfo($file['name'], PATHINFO_EXTENSION)
            );

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($file['tmp_name']);

            if (
                !in_array($extension, $allowedExtensions, true) ||
                !in_array($mimeType, $allowedMimeTypes, true)
            ) {

                $message = "Only JPG, JPEG and PNG files are allowed.";
                $messageType = "danger";

            } else {

                $uploadDirectory = '../uploads/profile_pictures/';

                if (!is_dir($uploadDirectory)) {

                    mkdir($uploadDirectory, 0755, true);

                }

                $newFileName =
                    uniqid('profile_', true) . '.' . $extension;

                $destination =
                    $uploadDirectory . $newFileName;

                if (move_uploaded_file(
                    $file['tmp_name'],
                    $destination
                )) {

                    $oldData = $user->getById($userId);
                    $oldFileName = $oldData['profile_picture'] ?? '';

                    if ($user->updateProfilePicture(
                        $userId,
                        $newFileName
                    )) {

                        if (
                            $oldFileName !== '' &&
                            $oldFileName !== $newFileName
                        ) {

                            $oldFilePath =
                                $uploadDirectory . basename($oldFileName);

                            if (is_file($oldFilePath)) {

                                unlink($oldFilePath);

                            }

                        }

                        $message =
                            "Profile picture uploaded successfully.";

                        $messageType = "success";

                    } else {

                        if (is_file($destination)) {

                            unlink($destination);

                        }

                        $message =
                            "Failed to save the profile picture.";

                        $messageType = "danger";
                    }

                } else {

                    $message =
                        "Failed to save the uploaded file.";

                    $messageType = "danger";
                }
            }
        }
    }
}

$data = $user->getStudentProfile($userId);

if (!$data) {

    die("Student profile not found.");

}

include '../views/profile.php';

?>