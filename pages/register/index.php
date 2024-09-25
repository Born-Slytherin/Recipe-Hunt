<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="../../global.css" />
  <link rel="stylesheet" href="./style.css" />
  <script src="./main.js" type="module" defer></script>
</head>

<body>

<?php 
  require_once("../../utils/tables.php")
?>
<!-- toast -->
<div id="toast-container"></div>


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
      <form id="signUpForm">
        <h3>Sign Up</h3>

        <div class="credentials">
          <input type="text" name="username" placeholder="Username" required />
          <input type="text" name="fullname" placeholder="Full Name" required />
          <input type="email" name="email" placeholder="Email" required />

          <div class="password">
            <input type="password" name="password" class="pwd" placeholder="Password" required minlength="8" />
            <img src="../../assets/eye-open.svg" alt="" class="eye-open" id="password-eye-open" />
            <img src="../../assets/eye-closed.svg" alt="" class="eye-closed" id="password-eye-closed" />
          </div>

          <div class="password">
            <input type="password" class="confirm-pwd" name="confirm_password" placeholder="Confirm Password" required />
            <img src="../../assets/eye-open.svg" alt="" class="eye-open" id="confirm-eye-open" />
            <img src="../../assets/eye-closed.svg" alt="" class="eye-closed" id="confirm-eye-closed" />
          </div>
        </div>

        <button type="submit" class="sign-up">SIGN UP</button>

        <!-- Sign Up -->
        <span class="sign-in">Already have an account? <a href="../login/index.php">Sign In</a></span>
      </form>
    </div>
  </section>

</body>

</html>