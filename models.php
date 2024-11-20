<?php
function getAllApplicants($conn) {
    $sql = "SELECT * FROM applicants ORDER BY date_applied DESC";
    $result = $conn->query($sql);

    if ($result) {
        return [
            "message" => "Applicants retrieved successfully.",
            "statusCode" => 200,
            "querySet" => $result->fetch_all(MYSQLI_ASSOC)
        ];
    } else {
        return [
            "message" => "Error fetching applicants: " . $conn->error,
            "statusCode" => 400
        ];
    }
}

function searchApplicants($conn, $keyword) {
    $keyword = "%$keyword%";
    $sql = "SELECT * FROM applicants WHERE 
            name LIKE ? OR 
            email LIKE ? OR 
            phone LIKE ? OR 
            address LIKE ? OR 
            position_applied LIKE ? 
            ORDER BY date_applied DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $keyword, $keyword, $keyword, $keyword, $keyword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        return [
            "message" => "Search successful.",
            "statusCode" => 200,
            "querySet" => $result->fetch_all(MYSQLI_ASSOC)
        ];
    } else {
        return [
            "message" => "Error during search: " . $stmt->error,
            "statusCode" => 400
        ];
    }
}

function getApplicantById($conn, $id) {
    $sql = "SELECT * FROM applicants WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        return [
            "message" => "Applicant found.",
            "statusCode" => 200,
            "querySet" => $result->fetch_assoc()
        ];
    } else {
        return [
            "message" => "Applicant not found.",
            "statusCode" => 400
        ];
    }
}

function insertApplicant($conn, $data) {
    $sql = "INSERT INTO applicants (name, email, phone, address, position_applied, resume) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssss",
        $data['name'],
        $data['email'],
        $data['phone'],
        $data['address'],
        $data['position_applied'],
        $data['resume']
    );

    if ($stmt->execute()) {
        return [
            "message" => "Applicant added successfully.",
            "statusCode" => 200
        ];
    } else {
        return [
            "message" => "Error adding applicant: " . $stmt->error,
            "statusCode" => 400
        ];
    }
}

function updateApplicant($conn, $id, $data) {
    $sql = "UPDATE applicants SET 
            name = ?, 
            email = ?, 
            phone = ?, 
            address = ?, 
            position_applied = ?, 
            resume = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssi",
        $data['name'],
        $data['email'],
        $data['phone'],
        $data['address'],
        $data['position_applied'],
        $data['resume'],
        $id
    );

    if ($stmt->execute()) {
        return [
            "message" => "Applicant updated successfully.",
            "statusCode" => 200
        ];
    } else {
        return [
            "message" => "Error updating applicant: " . $stmt->error,
            "statusCode" => 400
        ];
    }
}

function deleteApplicant($conn, $id) {
    $sql = "DELETE FROM applicants WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        return [
            "message" => "Applicant deleted successfully.",
            "statusCode" => 200
        ];
    } else {
        return [
            "message" => "Error deleting applicant: " . $stmt->error,
            "statusCode" => 400
        ];
    }
}
function countApplicants($conn) {
    $sql = "SELECT COUNT(*) AS total FROM applicants";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total'];
    } else {
        return 0;
    }
}

?>
