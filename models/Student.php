<?php

class Student
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAll()
    {
        $sql = "SELECT *
                FROM students
                ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function getById($id)
    {
        $sql = "SELECT *
                FROM students
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function getByIdAndUser($id, $userId)
    {
        $sql = "SELECT *
                FROM students
                WHERE id = ?
                AND user_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $id, $userId);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function create($userId, $name, $icno, $program, $marks)
    {
        $sql = "INSERT INTO students
                (user_id, name, icno, program, marks)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "isssi",
            $userId,
            $name,
            $icno,
            $program,
            $marks
        );

        return $stmt->execute();
    }

    public function update(
        $id,
        $userId,
        $name,
        $icno,
        $program,
        $marks
    ) {
        $sql = "UPDATE students
                SET name = ?,
                    icno = ?,
                    program = ?,
                    marks = ?
                WHERE id = ?
                AND user_id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "sssiii",
            $name,
            $icno,
            $program,
            $marks,
            $id,
            $userId
        );

        return $stmt->execute();
    }

    public function delete($id, $userId)
    {
        $sql = "DELETE FROM students
                WHERE id = ?
                AND user_id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ii",
            $id,
            $userId
        );

        return $stmt->execute();
    }
}

?>
