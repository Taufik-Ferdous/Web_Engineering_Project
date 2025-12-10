<?php
$host = 'localhost';
$db   = 'easybreak_db';
$user = 'root';
$pass = ''; // XAMPP default; change if you set a password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
