<!DOCTYPE html>

<html>

<head>

    <title>Add Student</title>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="../../public/css/style.css">

</head>

<body>

<div class="container mt-5">

    <div class="card">

        <div class="card-header">

            <h4>Add Student</h4>

        </div>

        <div class="card-body">

            <form
                action="../../controllers/StudentController.php?action=create"
                method="POST"
                class="needs-validation"
                novalidate>

                <div class="mb-3">

                    <label class="form-label">
                        Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        pattern="[A-Za-z ]+"
                        required>

                    <div class="invalid-feedback">
                        Please enter a valid name.
                    </div>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        IC No
                    </label>

                    <input
                        type="text"
                        name="icno"
                        class="form-control"
                        pattern="[0-9]{12}"
                        maxlength="12"
                        required>

                    <div class="invalid-feedback">
                        IC No must contain exactly 12 digits.
                    </div>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Program
                    </label>

                    <input
                        type="text"
                        name="program"
                        class="form-control"
                        required>

                    <div class="invalid-feedback">
                        Please enter the program.
                    </div>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Marks
                    </label>

                    <input
                        type="number"
                        name="marks"
                        class="form-control"
                        min="0"
                        max="100"
                        required>

                    <div class="invalid-feedback">
                        Marks must be between 0 and 100.
                    </div>

                </div>

                <button
                    type="submit"
                    class="btn btn-success">

                    Add Student

                </button>

                <a
                    href="../../index.php"
                    class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>


<script>

(function () {

    'use strict';

    var forms =
        document.querySelectorAll('.needs-validation');

    Array.prototype.slice.call(forms)
        .forEach(function (form) {

            form.addEventListener(
                'submit',
                function (event) {

                    if (!form.checkValidity()) {

                        event.preventDefault();
                        event.stopPropagation();

                    }

                    form.classList.add(
                        'was-validated'
                    );

                },
                false
            );

        });

})();

</script>

</body>

</html>