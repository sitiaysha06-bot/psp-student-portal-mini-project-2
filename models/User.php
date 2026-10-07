<?php

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getById($id)
    {
        $sql = "SELECT *
                FROM users
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function getByEmail($email)
    {
        $sql = "SELECT *
                FROM users
                WHERE email = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function getStudentProfile($userId)
    {
        $sql = "SELECT
                    users.id,
                    users.username,
                    users.email,
                    users.profile_picture,
                    students.name,
                    students.icno,
                    students.program,
                    students.marks
                FROM users
                INNER JOIN students
                    ON users.id = students.user_id
                WHERE users.id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function updateProfilePicture($id, $fileName)
    {
        $sql = "UPDATE users
                SET profile_picture = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $fileName, $id);

        return $stmt->execute();
    }

    public function updatePassword($id, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE users
                SET password = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $hashedPassword, $id);

        return $stmt->execute();
    }
}

?>