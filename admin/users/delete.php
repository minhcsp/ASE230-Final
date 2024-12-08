<?php
session_start();
include('../../db.php');

// Check if admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../login.php');
    exit;
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Prevent deletion of user with USER_ID = 1 (usually the admin)
    if ($userId == 1) {
        echo "<script>alert('You cannot delete the this User.'); window.history.back();</script>";
        exit;
    }

    // Delete the user
    $deleteQuery = "DELETE FROM USERS WHERE USER_ID = '$userId'";

    if ($conn->query($deleteQuery)) {
        header('Location: index.php');
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "No user ID provided.";
    exit;
}

$conn->close();
?>
