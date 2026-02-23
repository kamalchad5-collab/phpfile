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
$conn->query("DELETE FROM users WHERE id=$id");
$conn->close();

header("Location: users.php");
exit;
?>
