<?php
session_start();
include('../../db.php');

// Check if admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../login.php');
    exit;
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user details
    $query = "SELECT USER_ID, USERNAME, ROLE FROM USERS WHERE USER_ID = '$userId'";
    $result = $conn->query($query);

    if ($result->num_rows == 0) {
        echo "User not found!";
        exit;
    }

    $user = $result->fetch_assoc();
} else {
    echo "No user ID provided.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $role = $_POST['role'];

    // Update user details
    $updateQuery = "UPDATE USERS SET USERNAME = '$username', ROLE = '$role' WHERE USER_ID = '$userId'";

    if ($conn->query($updateQuery)) {
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
    <title>Edit User</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        header { background-color: #333; color: white; padding: 20px; text-align: center; }
        nav { margin-top: 10px; }
        nav a { color: white; text-decoration: none; font-weight: bold; margin: 0 15px; }
        form { background-color: white; padding: 20px; margin: 20px auto; width: 80%; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
        label { font-weight: bold; display: block; margin: 10px 0 5px; }
        input[type="text"], select { width: 100%; padding: 10px; margin: 10px 0; font-size: 1em; }
        input[type="submit"] { background-color: #007BFF; color: white; padding: 10px 15px; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <header>
        <h1>Edit User: <?php echo $user['USERNAME']; ?></h1>
        <nav>
            <a href="index.php">Back to Users</a> | <a href="../../logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $user['USERNAME']; ?>" required>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="user" <?php if ($user['ROLE'] == 'user') echo 'selected'; ?>>User</option>
                <option value="admin" <?php if ($user['ROLE'] == 'admin') echo 'selected'; ?>>Admin</option>
            </select>

            <input type="submit" value="Update User">
        </form>
    </main>
</body>
</html>

<?php $conn->close(); ?>
