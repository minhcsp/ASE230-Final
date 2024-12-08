<?php
session_start();
include('db.php');

// Fetch all posts
$query = "SELECT p.POST_ID, p.TITLE, p.CONTENT, p.IMAGE, u.USERNAME FROM POSTS p JOIN USERS u ON p.USER_ID = u.USER_ID ORDER BY p.POST_ID ASC";
$result = $conn->query($query);

// Check if the user is logged in
$loggedIn = isset($_SESSION['username']);
$isAdmin = $loggedIn && isset($_SESSION['role']) && $_SESSION['role'] == 'admin'; // Check if user is admin
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My CMS - Home</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <!-- Header Section -->
    <header style="background-color: #333; color: white; padding: 20px 0;">
        <div style="width: 80%; margin: 0 auto; text-align: center;">
            <h1 style="margin: 0;">Content Management System</h1>
            <nav>
                <ul style="list-style-type: none; padding: 0; text-align: center;">
                    <li style="display: inline; margin-right: 15px;">
                        <a href="index.php" style="color: white; text-decoration: none; font-weight: bold;">Home</a>
                    </li>
                    <?php if ($loggedIn): ?>
                        <?php if ($isAdmin): ?>
                            <li style="display: inline; margin-right: 15px;">
                                <a href="admin/posts/index.php" style="color: white; text-decoration: none; font-weight: bold;">Admin Dashboard</a>
                            </li>
                        <?php endif; ?>
                        <?php if ($_SESSION['role'] == 'user'): ?>
                            <li style="display: inline; margin-right: 15px;">
                                <a href="user/index.php" style="color: white; text-decoration: none; font-weight: bold;">User Dashboard</a>
                            </li>
                        <?php endif; ?>
                        <li style="display: inline; margin-right: 15px;">
                            <a href="logout.php" style="color: white; text-decoration: none; font-weight: bold;">Logout</a>
                        </li>
                    <?php else: ?>
                        <li style="display: inline; margin-right: 15px;">
                            <a href="login.php" style="color: white; text-decoration: none; font-weight: bold;">Login</a>
                        </li>
                        <li style="display: inline; margin-right: 15px;">
                            <a href="signup.php" style="color: white; text-decoration: none; font-weight: bold;">Sign Up</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Logged In Info Section (Outside of Navbar) -->
    <?php if ($loggedIn): ?>
        <div style="width: 80%; margin: 20px auto; text-align: center; font-size: 1.2em;">
            <p style="color: #333;">Logged in as <strong><?php echo $_SESSION['username']; ?></strong> (Role: <strong><?php echo $_SESSION['role']; ?></strong>)</p>
        </div>
    <?php endif; ?>

    <!-- Main Content Section -->
    <main style="padding: 20px 0;">
        <div style="width: 80%; margin: 0 auto;">
            <h2>Latest Posts</h2>

            <?php if ($result->num_rows > 0): ?>
                <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                    <?php while($post = $result->fetch_assoc()): ?>
                        <div style="background-color: white; padding: 15px; margin-bottom: 20px; width: 30%; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                            <h3 style="font-size: 1.5em; color: #333;"><?php echo $post['TITLE']; ?></h3>
                            <p style="color: #777; font-size: 0.9em;">By <?php echo $post['USERNAME']; ?></p>
                            <img src="<?php echo $post['IMAGE']; ?>" alt="Post Image" style="width: 100%; height: auto; margin-top: 10px;">
                            <p style="font-size: 1em; color: #555;"><?php echo substr($post['CONTENT'], 0, 150) . '...'; ?></p>
                            <a href="detail.php?id=<?php echo $post['POST_ID']; ?>" style="color: #007BFF; text-decoration: none;">Read More</a>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No posts available.</p>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer Section -->
    <footer style="background-color: #333; color: white; padding: 10px 0; text-align: center;">
        <div style="width: 80%; margin: 0 auto;">
            <p>&copy; 2024 My CMS. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
