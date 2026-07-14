<?php
$host = "localhost";
$dbname = "your_db_name_here";
$username = "your_username_here";
$password = "your_password_here";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
