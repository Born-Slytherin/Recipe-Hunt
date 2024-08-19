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
        <form>
          <h3>Sign Up</h3>

          <div class="credentials">
            <input type="text" name="" placeholder="Username" required />
            <input type="text" name="" placeholder="Full Name" required />
            <input
              type="email"
              name=""
              placeholder="Email"
              required
              pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
            />

            <div class="password">
              <input
                type="password"
                name=""
                class="pwd"
                placeholder="Password"
                required
                minlength="8"
              />

              <!-- Eye Image -->
              <img
                src="../../assets/eye-open.svg"
                alt=""
                class="eye-open"
                id="password-eye-open"
              />
              <img
                src="../../assets/eye-closed.svg"
                alt=""
                class="eye-closed"
                id="password-eye-closed"
              />
            </div>

            <div class="password">
              <input
                type="password"
                class="confirm-pwd"
                name=""
                placeholder="Confirm Password"
                required
                minlength="8"
              />

              <!-- Eye Image -->
              <img
                src="../../assets/eye-open.svg"
                alt=""
                class="eye-open"
                id="confirm-eye-open"
              />
              <img
                src="../../assets/eye-closed.svg"
                alt=""
                class="eye-closed"
                id="confirm-eye-closed"
              />
            </div>
          </div>

          <button type="submit">SIGN UP</button>

          <!-- Sign Up -->
          <span class="sign-in"
            >Already have an account?
            <a href="../login/index.html">Sign In</a></span
          >
        </form>
      </div>
    </section>
  </body>
</html>
