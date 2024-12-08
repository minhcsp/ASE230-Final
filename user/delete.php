<?php
session_start();
include('../db.php');

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit;
}

$postId = $_GET['id'];
$query = "DELETE FROM POSTS WHERE POST_ID = $postId";
if ($conn->query($query)) {
    header('Location: index.php');
} else {
    echo "Error: " . $conn->error;
}
?>
