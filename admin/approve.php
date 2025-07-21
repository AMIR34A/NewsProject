<?php
include '../config.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = (int)$_GET['id'];
    $status = $_GET['status'];

    if (in_array($status, ['approved', 'rejected'])) {
        $sql = "UPDATE news SET status = '$status' WHERE id = $id";
        mysqli_query($conn, $sql);
    }
}

header("Location: index.php");
exit();
