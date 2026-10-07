<?php

include 'config/database.php';

$password = "Aysha@1686";

$hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE users SET password = ? WHERE id = 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hash);

if ($stmt->execute()) {

    echo "Password updated successfully.";

} else {

    echo "Failed to update password.";

}

?>