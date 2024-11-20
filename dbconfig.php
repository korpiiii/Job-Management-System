<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_applicants_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode([
        "message" => "Connection failed: " . $conn->connect_error,
        "statusCode" => 400
    ]));
}
?>
