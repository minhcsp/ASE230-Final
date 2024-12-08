<?php
session_start();
include('../../db.php');

// Check if admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../login.php');
    exit;
}

if (isset($_GET['id'])) {
    $postId = $_GET['id'];

    // Fetch the post based on ID, including created_at and updated_at
    $query = "SELECT p.POST_ID, p.TITLE, p.CONTENT, p.IMAGE, p.CREATED_AT, p.UPDATED_AT, u.USERNAME 
              FROM POSTS p 
              JOIN USERS u ON p.USER_ID = u.USER_ID 
              WHERE p.POST_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $postId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    } else {
        echo "Post not found!";
        exit;
    }
} else {
    echo "No post ID provided!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Detail</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        header { background-color: #333; color: white; padding: 20px; text-align: center; }
        nav { margin-top: 10px; }
        nav a { color: white; text-decoration: none; font-weight: bold; margin: 0 15px; }
        .post-detail { background-color: white; padding: 20px; margin: 20px auto; width: 80%; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
        .post-detail h3 { color: #333; }
        .post-detail p { color: #777; line-height: 1.6; }
        .post-detail img { max-width: 100%; height: auto; margin: 20px 0; }
        .action-links { margin-top: 20px; }
        .action-links a { color: #007BFF; text-decoration: none; font-weight: bold; margin: 0 10px; }
    </style>
</head>
<body>
    <header>
        <h1>Post Detail</h1>
        <nav>
            <a href="index.php">Back to Posts</a> | <a href="../../logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <div class="post-detail">
            <h3><?php echo htmlspecialchars($post['TITLE']); ?></h3>
            <?php if (!empty($post['IMAGE'])): ?>
                <img src="<?php echo htmlspecialchars($post['IMAGE']); ?>" alt="Post Image">
            <?php endif; ?>
            <p><strong>Author:</strong> <?php echo htmlspecialchars($post['USERNAME']); ?></p>
            <p><strong>Content:</strong> <?php echo nl2br(htmlspecialchars($post['CONTENT'])); ?></p>
            <p><strong>Created At:</strong> <?php echo htmlspecialchars($post['CREATED_AT']); ?></p>
            <p><strong>Updated At:</strong> <?php echo htmlspecialchars($post['UPDATED_AT']); ?></p>

            <div class="action-links">
                <a href="edit.php?id=<?php echo $post['POST_ID']; ?>">Edit Post</a> |
                <a href="delete.php?id=<?php echo $post['POST_ID']; ?>" onclick="return confirm('Are you sure you want to delete this post?')">Delete Post</a>
            </div>
        </div>
    </main>
</body>
</html>

<?php $conn->close(); ?>
