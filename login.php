<?php
include("database.php");
session_start();

$openModal = false; // Default: Do not open modal
$message = ""; // Message to display in the modal
$isSuccess = false; // Flag to check login success

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check user credentials
    $sql = "SELECT * FROM login WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Login successful
        $user = mysqli_fetch_assoc($result);

        $_SESSION['email']=$user['email'];
    
        header("Location: index.html");
    } else {
        echo "Login Failed";
    }
}
?>