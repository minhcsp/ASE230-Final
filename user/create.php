<?php
session_start();
include('../db.php');

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit;
}

$username = $_SESSION['username'];

// Fetch the USER_ID based on the username
$query = "SELECT USER_ID FROM USERS WHERE USERNAME = '$username'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $userId = $user['USER_ID'];
} else {
    echo "User not found!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_POST['image'];

    // Insert the new post with the USER_ID
    $insertQuery = "INSERT INTO POSTS (USER_ID, TITLE, CONTENT, IMAGE) VALUES ('$userId', '$title', '$content', '$image')";
    
    if ($conn->query($insertQuery)) {
        header('Location: index.php');
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        header { background-color: #333; color: white; padding: 20px; text-align: center; }
        nav { margin-top: 10px; }
        nav a { color: white; text-decoration: none; font-weight: bold; margin: 0 15px; }
        form { background-color: white; padding: 20px; margin: 20px auto; width: 80%; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
        label { font-weight: bold; display: block; margin: 10px 0 5px; }
        input[type="text"], textarea { width: 100%; padding: 10px; margin: 10px 0; font-size: 1em; }
        input[type="submit"] { background-color: #007BFF; color: white; padding: 10px 15px; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <header>
        <h1>Create New Post</h1>
        <nav>
            <a href="index.php">Back to Dashboard</a> | <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <form method="POST">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="5" required></textarea>

            <label for="image">Image URL:</label>
            <input type="text" id="image" name="image" required>

            <input type="submit" value="Create Post">
        </form>
    </main>
</body>
</html>

<?php $conn->close(); ?>
