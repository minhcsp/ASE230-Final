<?php
session_start();
include('../../db.php');

// Check if admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../login.php');
    exit;
}

// Fetch all posts
$query = "SELECT p.POST_ID, p.TITLE, p.CONTENT, u.USERNAME FROM POSTS p JOIN USERS u ON p.USER_ID = u.USER_ID ORDER BY p.POST_ID ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Posts</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        header { background-color: #333; color: white; padding: 20px; text-align: center; }
        nav { margin-top: 10px; text-align: center; }
        nav a { color: white; text-decoration: none; font-weight: bold; margin: 0 15px; }
        h2 { text-align: center; padding: 20px; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
        table th, table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        table th { background-color: #f4f4f4; font-weight: bold; }
        table tr:nth-child(even) { background-color: #f9f9f9; }
        .action-links a { color: #007bff; text-decoration: none; margin-right: 10px; }
    </style>
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
        <nav>
            <a href="../../index.php">Home</a>
            <a href="../users/index.php">Manage Users</a>
            <a href="index.php">Manage Posts</a>
            <a href="create.php">Create New Post</a>
            <a href="../../logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Post ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['POST_ID']; ?></td>
                            <td><?php echo $row['TITLE']; ?></td>
                            <td><?php echo $row['USERNAME']; ?></td>
                            <td class="action-links">
                                <a href="detail.php?id=<?php echo $row['POST_ID']; ?>">View</a>
                                <a href="edit.php?id=<?php echo $row['POST_ID']; ?>">Edit</a>
                                <a href="delete.php?id=<?php echo $row['POST_ID']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center;">No posts available.</p>
        <?php endif; ?>
    </main>
</body>
</html>

<?php $conn->close(); ?>
