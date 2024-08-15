<?php 
  require_once("../../components/modal.php")
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
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

      <!-- Burger Image -->
      <div class="burger">
        <img src="../../assets/login-burger.svg" alt="Image" />
      </div>

      <!-- Login form -->
      <div class="auth">
        <form>
          <h3>Welcome Back</h3>

          <div class="credentials">
            <input type="text" name="" placeholder="Username" />
            <div class="password">
              <input type="password" name="" id="pwd" placeholder="Password" />

              <!-- Eye Image -->
              <img src="../../assets/eye-open.svg" alt="" class="eye-open" />
              <img
                src="../../assets/eye-closed.svg"
                alt=""
                class="eye-closed"
              />
            </div>

            <!-- Forgot password -->
            <div class="forgot">
              <a href="#">Forgot Password?</a>
            </div>
          </div>

          <button type="submit">LOGIN</button>

          <!-- Sign Up -->
          <span class="sign-up"
            >Don't have an account?
            <a href="../register/index.html">Sign Up</a></span
          >
        </form>
      </div>
    </section>
  </body>
</html>