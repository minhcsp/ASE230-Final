<?php
session_start();
include('../../db.php');

// Check if admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../login.php');
    exit;
}

// Get post ID
$postId = $_GET['id'] ?? null;
if (!$postId) {
    header('Location: index.php');
    exit;
}

// Delete post
$query = "DELETE FROM POSTS WHERE POST_ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $postId);

if ($stmt->execute()) {
    header('Location: index.php');
    exit;
} else {
    $error = "Failed to delete the post.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Post</title>
</head>
<body>
    <p><?php echo $error; ?></p>
</body>
</html>
