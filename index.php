<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recipe Hunt</title>
    <link rel="stylesheet" href="./style.css" />
    <link rel="stylesheet" href="./global.css" />
</head>
<body>

<?php

if (isset($_COOKIE["user"])) {
    header("Location: ./pages/home/index.php");
    exit();
}

if (isset($_POST['explore'])) {
    header("Location: ./pages/login/index.php");
    exit();
}
?>

<!-- Wrapper -->
<section class="wrapper">
    <!-- Logo -->
    <div class="logo">
        <img src="./assets/logo-white.svg" alt="Recipe Hunt Logo" />
    </div>

    <!-- Landing Image -->
    <div class="landing-image">
        <img src="./assets/landing-girl-image.png" alt="Landing girl image" />
    </div>

    <!-- Falling Hamburger image -->
    <div class="hamburger">
        <img src="./assets/hamburger.svg" alt="" />
    </div>

    <!-- Tag line Div -->
    <div class="tagline">
        <p>
            The <br />
            <span>Foodie <br /></span>
            spot
        </p>
    </div>

    <!-- Line arrow -->
    <div class="line-arrow">
        <img src="./assets/line-arrow.svg" alt="" />
    </div>

    <!-- Explore button wrapped in a form -->
    <form method="POST">
        <button type="submit" class="explore" name="explore">Explore</button>
    </form>
</section>

</body>
</html>
