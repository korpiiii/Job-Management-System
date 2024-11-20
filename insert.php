<?php
include 'dbconfig.php';
include 'models.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = insertApplicant($conn, $_POST);
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
    <title>Add Applicant</title>
</head>
<body>
    <h1>Add Applicant</h1>
    <form method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone">
        <textarea name="address" placeholder="Address" required></textarea>
        <input type="text" name="position_applied" placeholder="Position" required>
        <textarea name="resume" placeholder="Resume" required></textarea>
        <button type="submit">Add Applicant</button>
    </form>
    <a href="index.php" class="back-button">Back to Homepage</a>
</body>
</html>
