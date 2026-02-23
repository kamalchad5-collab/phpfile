<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$host = "localhost";
$db_user = "webuser";
$db_pass = "StrongPassword123!";
$db_name = "user_management";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View User</title>
</head>
<body>
    <h2>User Details</h2>
    <?php if($user): ?>
        <p><strong>Username:</strong> <?= $user['username'] ?></p>
        <p><strong>Full Name:</strong> <?= $user['fullname'] ?></p>
        <p><strong>Gender:</strong> <?= $user['gender'] ?></p>
        <p><strong>Country:</strong> <?= $user['country'] ?></p>
        <p><strong>Hobbies:</strong> <?= $user['hobbies'] ?></p>
    <?php else: ?>
        <p>User not found!</p>
    <?php endif; ?>
    <a href="users.php">Back to Users List</a>
</body>
</html>
