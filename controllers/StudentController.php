<?php

session_start();

include '../config/database.php';
include '../models/Student.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: ../views/login.php");
    exit;
}

$student = new Student($conn);

$userId = $_SESSION['user_id'];

$action = $_GET['action'] ?? '';


if ($action === 'create') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        header("Location: ../views/students/create.php");
        exit;
    }

    $name = trim($_POST['name'] ?? '');
    $icno = trim($_POST['icno'] ?? '');
    $program = trim($_POST['program'] ?? '');
    $marks = $_POST['marks'] ?? '';

    if (
        $name === '' ||
        $icno === '' ||
        $program === '' ||
        $marks === ''
    ) {
        die("Please fill in all fields.");
    }

    if (!preg_match('/^[A-Za-z ]+$/', $name)) {
        die("Name can contain letters and spaces only.");
    }

    if (!preg_match('/^[0-9]{12}$/', $icno)) {
        die("IC No must contain exactly 12 digits.");
    }

    if (!is_numeric($marks) || $marks < 0 || $marks > 100) {
        die("Marks must be between 0 and 100.");
    }

    $marks = (int)$marks;

    if (
        $student->create(
            $userId,
            $name,
            $icno,
            $program,
            $marks
        )
    ) {

        header("Location: ../index.php");
        exit;

    } else {

        if ($conn->errno == 1062) {
            die("This IC No already exists.");
        }

        die("Failed to add student.");
    }
}



if ($action === 'update') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        header("Location: ../index.php");
        exit;
    }

    $id = $_POST['id'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $icno = trim($_POST['icno'] ?? '');
    $program = trim($_POST['program'] ?? '');
    $marks = $_POST['marks'] ?? '';

    if (
        $id === '' ||
        $name === '' ||
        $icno === '' ||
        $program === '' ||
        $marks === ''
    ) {
        die("Please fill in all fields.");
    }

    if (!is_numeric($id) || $id <= 0) {
        die("Invalid student ID.");
    }

    if (!preg_match('/^[A-Za-z ]+$/', $name)) {
        die("Name can contain letters and spaces only.");
    }

    if (!preg_match('/^[0-9]{12}$/', $icno)) {
        die("IC No must contain exactly 12 digits.");
    }

    if (!is_numeric($marks) || $marks < 0 || $marks > 100) {
        die("Marks must be between 0 and 100.");
    }

    $id = (int)$id;
    $marks = (int)$marks;

    if (
        $student->update(
            $id,
            $userId,
            $name,
            $icno,
            $program,
            $marks
        )
    ) {

        header("Location: ../index.php");
        exit;

    } else {

        if ($conn->errno == 1062) {
            die("This IC No already exists.");
        }

        die("Failed to update student.");
    }
}



if ($action === 'delete') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        header("Location: ../index.php");
        exit;
    }

    $id = $_POST['id'] ?? '';

    if (!is_numeric($id) || $id <= 0) {
        die("Invalid student ID.");
    }

    $id = (int)$id;

    if ($student->delete($id, $userId)) {

        header("Location: ../index.php");
        exit;

    } else {

        die("Failed to delete student.");
    }
}


header("Location: ../index.php");
exit;

?>