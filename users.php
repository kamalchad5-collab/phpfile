<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Database connection
$host = "localhost";
$db_user = "webuser";
$db_pass = "StrongPassword123!";
$db_name = "user_management";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users List</title>
    <style>
        table { border-collapse: collapse; width: 80%; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        a.button { text-decoration: none; padding: 5px 10px; border: 1px solid black; background: #ccc; margin-right: 5px; }
    </style>
</head>
<body>
    <h2>Users List</h2>
    <a href="logout.php">Logout</a> | <a href="add_user.php">Add New User</a>
    <br><br>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Gender</th>
            <th>Country</th>
            <th>Hobbies</th>
            <th>Actions</th>
        </tr>
        <?php
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['fullname']}</td>
                        <td>{$row['gender']}</td>
                        <td>{$row['country']}</td>
                        <td>{$row['hobbies']}</td>
                        <td>
                            <a class='button' href='view_user.php?id={$row['id']}'>View</a>
                            <a class='button' href='edit_user.php?id={$row['id']}'>Edit</a>
                            <a class='button' href='delete_user.php?id={$row['id']}' onclick=\"return confirm('Are you sure?')\">Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No users found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
