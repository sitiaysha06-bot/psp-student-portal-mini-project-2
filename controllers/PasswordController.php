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

if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    header("Location: ProfileController.php");
    exit;

}

$currentPassword = $_POST['current_password'] ?? '';
$newPassword = $_POST['new_password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

if (
    $currentPassword == '' ||
    $newPassword == '' ||
    $confirmPassword == ''
) {

    die("Please fill in all fields.");

}

if ($newPassword != $confirmPassword) {

    die("New password and confirm password do not match.");

}

if (strlen($newPassword) < 6) {

    die("New password must be at least 6 characters.");

}

$data = $user->getById($userId);

if (!$data) {

    die("User not found.");

}

if (!password_verify(
    $currentPassword,
    $data['password']
)) {

    die("Current password is incorrect.");

}

if ($user->updatePassword(
    $userId,
    $newPassword
)) {

    header("Location: ProfileController.php");
    exit;

} else {

    die("Failed to update password.");

}

?>

