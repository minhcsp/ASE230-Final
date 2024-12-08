<?php
session_start();
include('../../db.php');

// Check if admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_POST['image'];

    // Insert the new post
    $query = "INSERT INTO POSTS (TITLE, CONTENT, IMAGE, USER_ID) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Assuming admin can set USER_ID. Replace with actual ID logic if needed.
    $userId = 1; // Example: Admin's USER_ID is 1. Adjust logic as needed.
    $stmt->bind_param('sssi', $title, $content, $image, $userId);

    if ($stmt->execute()) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Error: " . $conn->error;
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
        input[type="submit"]:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <header>
        <h1>Create New Post</h1>
        <nav>
            <a href="index.php">Back to Posts</a> | <a href="../../logout.php">Logout</a>
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
        <?php if (isset($error)): ?>
            <p style="color: red; text-align: center;"><?php echo $error; ?></p>
        <?php endif; ?>
    </main>
</body>
</html>

<?php $conn->close(); ?>
