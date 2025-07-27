<?php
$host = "localhost";
$user = "root"; // Default XAMPP user
$pass = "";     // Default XAMPP password
$dbname = "smart_booking";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
