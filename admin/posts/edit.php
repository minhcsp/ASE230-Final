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

// Fetch post data
$query = "SELECT * FROM POSTS WHERE POST_ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $postId);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Update post
    $updateQuery = "UPDATE POSTS SET TITLE = ?, CONTENT = ? WHERE POST_ID = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param('ssi', $title, $content, $postId);

    if ($updateStmt->execute()) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Failed to update the post.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        header { background-color: #333; color: white; padding: 20px; text-align: center; }
        nav { margin-top: 10px; text-align: center; }
        nav a { color: white; text-decoration: none; font-weight: bold; margin: 0 15px; }
        form { width: 80%; margin: 20px auto; background: white; padding: 20px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, textarea { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; }
        button { padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <header>
        <h1>Edit Post</h1>
        <nav>
            <a href="../../index.php">Home</a>
            <a href="../users/index.php">Manage Users</a>
            <a href="index.php">Manage Posts</a>
            <a href="../../logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <form method="POST">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['TITLE']); ?>" required>

            <label for="content">Content</label>
            <textarea id="content" name="content" rows="10" required><?php echo htmlspecialchars($post['CONTENT']); ?></textarea>

            <button type="submit">Update Post</button>
            <button href="index.php">Cancel</button>
        </form>
        <?php if (isset($error)): ?>
            <p style="color: red; text-align: center;"><?php echo $error; ?></p>
        <?php endif; ?>
    </main>
</body>
</html>
