<?php
include 'dbconfig.php';
include 'models.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $id = $_POST['id'] ?? null;

    if (!$action) {
        echo json_encode(["message" => "No action specified.", "statusCode" => 400]);
        exit;
    }

    $response = $action === 'edit' && $id
        ? updateApplicant($conn, $id, $_POST)
        : ($action === 'delete' && $id ? deleteApplicant($conn, $id) : null);

    echo json_encode($response);
    exit;
}
?>
