<?php

session_start();

if (!isset($_SESSION['user_id'])) {

    header("Location: views/login.php");
    exit;
}

include 'config/database.php';
include 'models/Student.php';

$student = new Student($conn);

$result = $student->getAll();

?>

<!DOCTYPE html>

<html>

<head>

    <title>PSP Student Portal</title>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="public/css/style.css">

</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2>PSP Student Portal</h2>

            <p class="mb-0">

                Welcome,
                <?php echo htmlspecialchars($_SESSION['username']); ?>

            </p>

        </div>

        <div>

            <a
                href="controllers/ProfileController.php"
                class="btn btn-info">

                Profile

            </a>

            <a
                href="views/students/create.php"
                class="btn btn-success">

                Add Student

            </a>

            <a
                href="views/login.php"
                class="btn btn-danger"
                onclick="return confirm('Are you sure you want to logout?');">

                Logout

            </a>

        </div>

    </div>


    <div class="card">

        <div class="card-header">

            <h4>Student List</h4>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead>

                    <tr>

                        <th>ID</th>

                        <th>Name</th>

                        <th>IC No</th>

                        <th>Program</th>

                        <th>Marks</th>

                        <th>Action</th>

                    </tr>

                    </thead>

                    <tbody>

                    <?php

                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {

                    ?>

                    <tr>

                        <td>
                            <?php echo htmlspecialchars($row['id']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['name']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['icno']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['program']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['marks']); ?>
                        </td>

                        <td>

                            <?php

                            if ($row['user_id'] == $_SESSION['user_id']) {

                            ?>

                                <a
                                    href="views/students/edit.php?id=<?php echo $row['id']; ?>"
                                    class="btn btn-warning btn-sm">

                                    Edit

                                </a>

                                <form
                                    action="controllers/StudentController.php?action=delete"
                                    method="POST"
                                    style="display:inline;">

                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?php echo $row['id']; ?>">

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this student?');">

                                        Delete

                                    </button>

                                </form>

                            <?php

                            } else {

                            ?>

                                <span class="text-muted">
                                    View Only
                                </span>

                            <?php

                            }

                            ?>

                        </td>

                    </tr>

                    <?php

                        }

                    } else {

                    ?>

                    <tr>

                        <td
                            colspan="6"
                            class="text-center">

                            No student records found.

                        </td>

                    </tr>

                    <?php

                    }

                    ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>

</html>