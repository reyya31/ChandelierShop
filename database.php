<?php
$servername = '127.0.0.1';
$username = 'root';
$password = '';
$dbname = 'chandeliershop';

$conn = mysqli_connect($servername, $username, $password, $dbname, 3307); // If using port 3307

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>