<?php
session_start();
include('../../db.php');

// Check if admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../login.php');
    exit;
}

// Fetch all users, including created_at
$query = "SELECT USER_ID, USERNAME, ROLE, CREATED_AT, UPDATED_AT FROM USERS ORDER BY USER_ID DESC";
$result = $conn->query($query);

// Check if query was successful
if ($result === false) {
    echo "Error executing query: " . $conn->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        header { background-color: #333; color: white; padding: 20px; text-align: center; }
        nav { margin-top: 10px; }
        nav a { color: white; text-decoration: none; font-weight: bold; margin: 0 15px; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; background-color: white; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; color: #333; }
        tr:hover { background-color: #f1f1f1; }
        .action-links { color: #007BFF; font-weight: bold; }
        .created-at { font-size: 0.9em; color: #555; }
    </style>
</head>
<body>
<header>
    <h1>Admin Panel</h1>
    <nav>
        <a href="../../index.php">Home</a>
        <a href="index.php">Manage Users</a>
        <a href="../posts/index.php">Manage Posts</a>
        <a href="create.php">Create New Post</a>
        <a href="../../logout.php">Logout</a>
    </nav>
</header>

<main>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Account Created</th>
                <th>Account Updated</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['USERNAME']); ?></td>
                        <td><?php echo htmlspecialchars($user['ROLE']); ?></td>
                        <td class="created-at"><?php echo date('F j, Y, g:i a', strtotime($user['CREATED_AT'])); ?></td>
                        <td class="created-at"><?php echo date('F j, Y, g:i a', strtotime($user['UPDATED_AT'])); ?></td>
                        <td class="action-links">
                            <a href="edit.php?id=<?php echo $user['USER_ID']; ?>">Edit</a> | 
                            <a href="delete.php?id=<?php echo $user['USER_ID']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>
</body>
</html>

<?php $conn->close(); ?>
