<?php
session_start();
include('../db.php');

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit;
}

$postId = $_GET['id'];
$query = "SELECT p.POST_ID, p.TITLE, p.CONTENT, p.IMAGE, u.USERNAME FROM POSTS p JOIN USERS u ON p.USER_ID = u.USER_ID WHERE p.POST_ID = $postId";
$result = $conn->query($query);
$post = $result->fetch_assoc();
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
        .post-detail h2 { font-size: 2em; color: #333; }
        .post-detail p { color: #555; font-size: 1.1em; }
        .post-detail img { width: 100%; height: auto; margin-top: 20px; }
    </style>
</head>
<body>
    <header>
        <h1>Post Detail</h1>
        <nav>
            <a href="../index.php">Home</a>
            <a href="index.php">Back to Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <div class="post-detail">
            <h2><?php echo $post['TITLE']; ?></h2>
            <p><strong>By: <?php echo $post['USERNAME']; ?></strong></p>
            <img src="<?php echo $post['IMAGE']; ?>" alt="Post Image">
            <p><?php echo $post['CONTENT']; ?></p>
        </div>
    </main>
</body>
</html>

<?php $conn->close(); ?>
