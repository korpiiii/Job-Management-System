<?php
include 'dbconfig.php';
include 'models.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode([
        "message" => "Invalid Applicant ID",
        "statusCode" => 400
    ]);
    exit;
}

$applicant = getApplicantById($conn, $id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = updateApplicant($conn, $id, $_POST);
    header("Location: index.php?status=" . $response['statusCode']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edit Applicant</title>
</head>
<body>
    <h1>Edit Applicant</h1>
    <form method="POST">
        <input type="text" name="name" value="<?= htmlspecialchars($applicant['querySet']['name']) ?>" required>
        <input type="email" name="email" value="<?= htmlspecialchars($applicant['querySet']['email']) ?>" required>
        <input type="text" name="phone" value="<?= htmlspecialchars($applicant['querySet']['phone']) ?>">
        <textarea name="address" required><?= htmlspecialchars($applicant['querySet']['address']) ?></textarea>
        <input type="text" name="position_applied" value="<?= htmlspecialchars($applicant['querySet']['position_applied']) ?>" required>
        <textarea name="resume" required><?= htmlspecialchars($applicant['querySet']['resume']) ?></textarea>
        <button type="submit">Update Applicant</button>
    </form>
    <a href="index.php" class="back-button">Back to Homepage</a>
</body>
</html>
