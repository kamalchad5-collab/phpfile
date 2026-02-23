<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Database connection using the dedicated web user
$host = "localhost";
$db_user = "webuser";              // Your new MySQL user
$db_pass = "StrongPassword123!";   // Password you set
$db_name = "user_management";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

// Handle form submission
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Verify hashed password
        if(password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            header("Location: users.php"); // Redirect to users list page
            exit;
        } else {
            $message = "Invalid password!";
        }
    } else {
        $message = "User not found!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if($message) echo "<p style='color:red;'>$message</p>"; ?>
    <form method="post" action="">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
