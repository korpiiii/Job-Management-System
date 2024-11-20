<?php
include 'dbconfig.php';
include 'models.php';

$id = $_POST['id'] ?? null;
if ($id) {
    deleteApplicant($conn, $id);
}
