<?php
session_start();
include('../../db.php');

// Check if admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Check if the username already exists
    $checkQuery = "SELECT * FROM USERS WHERE USERNAME = '$username'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Username already exists
        $errorMessage = "The username '$username' is already taken. Please choose a different username.";
    } else {
        // Insert the new user if the username is unique
        $insertQuery = "INSERT INTO USERS (USERNAME, PASSWORD, ROLE, CREATED_AT) VALUES ('$username', '$password', '$role', NOW())";

        if ($conn->query($insertQuery)) {
            header('Location: index.php');
            exit;
        } else {
            $errorMessage = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New User</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        header { background-color: #333; color: white; padding: 20px; text-align: center; }
        nav { margin-top: 10px; }
        nav a { color: white; text-decoration: none; font-weight: bold; margin: 0 15px; }
        form { background-color: white; padding: 20px; margin: 20px auto; width: 80%; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
        label { font-weight: bold; display: block; margin: 10px 0 5px; }
        input[type="text"], input[type="password"], select { width: 100%; padding: 10px; margin: 10px 0; font-size: 1em; }
        input[type="submit"] { background-color: #007BFF; color: white; padding: 10px 15px; border: none; cursor: pointer; }
        .error { color: red; font-size: 1em; margin-top: 10px; }
    </style>
</head>
<body>
    <header>
        <h1>Create New User</h1>
        <nav>
            <a href="index.php">Back to Users</a> | <a href="../../logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <?php if (isset($errorMessage)): ?>
            <p class="error"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <input type="submit" value="Create User">
        </form>
    </main>
</body>
</html>

<?php $conn->close(); ?>
