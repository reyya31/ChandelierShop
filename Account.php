<?php
    include "database.php";
    if (isset($_POST["submit"])) {
        $firstname=$_POST["firstname"];
        $lastname=$_POST["lastname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $sql="select * from login where email='$email'";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)){
            echo "Email already exists";
            
        }      

        else{
    
                $sql = "INSERT INTO login (email, password,firstname,lastname) VALUES ('$email', '$password','$firstname','$lastname')";
                $result = mysqli_query($conn, $sql);

            } 
        } 
      
    
?>
    
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account - Chandelier.shop</title>
  <link rel="stylesheet" href="Account.css">
  <script src="Account.js" defer></script> 
</head>
<body>
  <header>
    <div class="nav__header">
      <div class="nav__logo">
        <a href="index.html" class="logo">Chandelier.shop</a>
      </div>
    </div>
  </header>

  <section class="account-section">
    <div class="modal-tabs">
      <!-- <button class="tab-btn" id="login-tab">Login</button>
      <button class="tab-btn" id="signup-tab">Sign Up</button> -->
    </div>

    <!-- Login Form -->
    <div class="login-box" id="login-form">
      <h1>Login</h1>
      <form action="login.php" method="POST">
          <label>Email</label>
          <input type="email" name="email" placeholder="Enter your email">
          <label>Password</label>
          <input type="password"  name="password" placeholder="Enter your password">
          <input type="submit" name="submit" value="Login">
      </form>
      <p class="para-2">Don't have an account? <a id="SignUp"> Sign Up Here</a></p>
    </div>

    <!-- Sign Up Form -->
    <div class="signup-box" id="signup-form" style="display: none;">
      <h1>Sign Up</h1>
      <p>It's free and only takes a minute</p>
      <form action="Account.php" method="POST">
          <label>First Name</label>
          <input type="text" name="firstname" placeholder="Enter your first name">
          <label>Last Name</label>
          <input type="text" name="lastname"placeholder="Enter your last name">
          <label>Email</label>
          <input type="email" name="email" placeholder="Enter your email">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter your password">
          <!-- <label>Confirm Password</label>
          <input type="password" placeholder="Confirm your password"> -->
          <input type="submit" name="submit" value="Sign Up">
      </form>
      <p>By clicking the Sign Up button, you agree to our<br>
      <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>
      </p>
    </div>
    <p class="para-2">Already have an account? <a id="Login"> Login</a></p>
  </section>
</body>
</html>
