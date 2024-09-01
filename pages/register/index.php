<?php
require_once("../../utils/tables.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="../../global.css" />
  <link rel="stylesheet" href="./style.css" />
  <script src="./main.js" defer></script>
</head>

<body>
  <section class="wrapper">
    <!-- Logo -->
    <div class="logo">
      <img src="../../assets/logo-white.svg" alt="" />
    </div>

    <!-- Pizza Image -->
    <div class="pizza">
      <img src="../../assets/pizza.svg" alt="" />
    </div>

    <!-- Register Form -->
    <div class="auth">
      <form method="POST">
        <h3>Sign Up</h3>

        <div class="credentials">
          <input type="text" name="username" placeholder="Username" required />   
          <input type="text" name="fullname" placeholder="Full Name" required />
          <input
            type="email"
            name="email"
            placeholder="Email"
            required />

          <div class="password">
            <input
              type="password"
              name="password"
              class="pwd"
              placeholder="Password"
              required
              minlength="8" />

            <!-- Eye Image -->
            <img
              src="../../assets/eye-open.svg"
              alt=""
              class="eye-open"
              id="password-eye-open" />
            <img
              src="../../assets/eye-closed.svg"
              alt=""
              class="eye-closed"
              id="password-eye-closed" />
          </div>

          <div class="password">
            <input
              type="password"
              class="confirm-pwd"
              name="confirm_password"
              placeholder="Confirm Password"
              required
              minlength="8" />

            <!-- Eye Image -->
            <img
              src="../../assets/eye-open.svg"
              alt=""
              class="eye-open"
              id="confirm-eye-open" />
            <img
              src="../../assets/eye-closed.svg"
              alt=""
              class="eye-closed"
              id="confirm-eye-closed" />
          </div>
        </div>

        <button type="submit" name="sign-up">SIGN UP</button>

        <!-- Sign Up -->
        <span class="sign-in">Already have an account?
          <a href="../login/index.html">Sign In</a></span>
      </form>
    </div>
  </section>
</body>

</html>

<?php

if (isset($_POST["sign-up"])) {
    $username = $_POST["username"];
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match.')</script>";
        return;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $checkUsername = "SELECT * FROM users WHERE username = '$username'";
    $checkEmail = "SELECT * FROM users WHERE email = '$email'";

    $resultUsername = mysqli_query($conn, $checkUsername);
    $resultEmail = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($resultUsername) > 0) {
        echo "<script>alert('Username already exists.')</script>";
    } else if (mysqli_num_rows($resultEmail) > 0) {
        echo "<script>alert('Email already exists.')</script>";
    } else {
        $sql = "INSERT INTO users (username, fullname, email, password) VALUES ('$username', '$fullname', '$email', '$hashedPassword')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Registration successful.')</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "')</script>";
        }
    }
}
?>