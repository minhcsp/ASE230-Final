<?php
session_start();
include('db.php');

// Check if the post ID is provided
if (isset($_GET['id'])) {
    $postId = $_GET['id'];

    // Fetch the post details from the database
    $query = "SELECT p.POST_ID, p.TITLE, p.CONTENT, p.IMAGE, u.USERNAME 
              FROM POSTS p 
              JOIN USERS u ON p.USER_ID = u.USER_ID 
              WHERE p.POST_ID = '$postId'";

    $result = $conn->query($query);

    // Check if the post exists
    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    } else {
        echo "Post not found.";
        exit;
    }
} else {
    echo "No post ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['TITLE']); ?> - My CMS</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        header { background-color: #333; color: white; padding: 20px 0; }
        nav a { color: white; text-decoration: none; font-weight: bold; margin: 0 15px; }
        .container { width: 80%; margin: 20px auto; }
        .post-title { font-size: 2em; color: #333; margin-bottom: 20px; }
        .post-meta { color: #777; font-size: 0.9em; margin-bottom: 20px; }
        .post-content { font-size: 1.2em; color: #555; }
        .post-image { width: 100%; height: auto; margin-top: 20px; }
        footer { background-color: #333; color: white; padding: 10px 0; text-align: center; margin-top: 40px; }
    </style>
</head>
<body>

<!-- Header Section -->
<header>
    <div style="width: 80%; margin: 0 auto; text-align: center;">
        <h1 style="margin: 0;">Content Management System</h1>
        <nav>
                <ul style="list-style-type: none; padding: 0; text-align: center;">
                    <li style="display: inline; margin-right: 15px;">
                        <a href="index.php" style="color: white; text-decoration: none; font-weight: bold;">Home</a>
                    </li>
                </ul>
            </nav>
    </div>
</header>

<!-- Main Content Section -->
<main class="container">
    <h2 class="post-title"><?php echo htmlspecialchars($post['TITLE']); ?></h2>

    <p class="post-meta">By <?php echo htmlspecialchars($post['USERNAME']); ?>

    <img class="post-image" src="<?php echo htmlspecialchars($post['IMAGE']); ?>" alt="Post Image">

    <div class="post-content">
        <?php echo nl2br(htmlspecialchars($post['CONTENT'])); ?>
    </div>
</main>

<!-- Footer Section -->
<footer>
    <p>&copy; 2024 My CMS. All Rights Reserved.</p>
</footer>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
