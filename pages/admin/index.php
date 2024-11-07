<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <!-- Routing using PHP -->
    <?php
    $user = $_COOKIE['user'] ?? null;
    if (!$user) {
        header("Location: ../login/index.php");
        exit;
    }

    if (isset($_POST['sign_out'])) {
        setcookie('user', '', time() - 3600, '/');
        header("Location: ../login/index.php");
        exit; // Ensure no further code is executed after redirect
    }
    ?>

    <!-- Dynamically setting icons and routes -->
    <?php
    $iconArray = [
        [
            "icon" => "../../assets/admin/user.svg",
            "include" => "userManagement.php",
        ],
        [
            "icon" => "../../assets/admin/envelop.svg",
            "include" => "AcceptRecipe.php",
        ],
        [
            "icon" => "../../assets/admin/food.svg",
            "include" => "foodManagement.php"
        ]
    ];
    ?>
    
    <header>
        <img src="../../assets/logo-white.svg" alt="">
        <form method="POST">
            <span><?php echo htmlspecialchars($user); ?></span>
            <button type="submit" name="sign_out">Sign Out</button>
        </form>
    </header>

    <main>
        <nav class="sideNav">
            <?php 
                foreach ($iconArray as $item) { // Corrected loop syntax
            ?>
                <div>
                    <img src="<?php echo $item['icon']; ?>" alt="">
                </div>
            <?php 
                } // Close the foreach loop
            ?>
        </nav>
    </main>
</body>

</html>
