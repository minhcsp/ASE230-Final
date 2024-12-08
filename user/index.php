<?php
session_start();
include('../db.php');

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit;
}

$username = $_SESSION['username'];
$query = "SELECT p.POST_ID, p.TITLE, p.CONTENT, p.IMAGE FROM POSTS p JOIN USERS u ON p.USER_ID = u.USER_ID WHERE u.USERNAME = '$username' ORDER BY p.POST_ID ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        header { background-color: #333; color: white; padding: 20px; text-align: center; }
        nav { margin-top: 10px; }
        nav a { color: white; text-decoration: none; font-weight: bold; margin: 0 15px; }
        h2 { text-align: center; padding: 20px; }
        .post { background-color: white; padding: 15px; margin: 20px 0; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); width: 80%; margin: 20px auto; }
        .post h3 { font-size: 1.5em; color: #333; }
        .post p { color: #777; }
        .post a { color: #007BFF; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
        <nav>
            <a href="../index.php">Home</a>
            <a href="create.php">Create New Post</a>
            <a href="../logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h2>Your Posts</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($post = $result->fetch_assoc()): ?>
                <div class="post">
                    <h3><a href="detail.php?id=<?php echo $post['POST_ID']; ?>"><?php echo $post['TITLE']; ?></a></h3>
                    <p><?php echo substr($post['CONTENT'], 0, 150) . '...'; ?></p>
                    <a href="edit.php?id=<?php echo $post['POST_ID']; ?>">Edit</a> |
                    <a href="delete.php?id=<?php echo $post['POST_ID']; ?>">Delete</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>You have not created any posts yet.</p>
        <?php endif; ?>
    </main>
</body>
</html>

<?php $conn->close(); ?>
