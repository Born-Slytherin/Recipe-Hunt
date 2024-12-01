<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>

    <?php
    $iconArray = [
        [
            "text" => "User Management",
            "key" => "user_management",
        ],
        [
            "text" => "Recipe Management",
            "key" => "recipe_management",
        ],
        [
            "text" => " Recipe Approval",
            "key" => "recipe_approval",
        ]
    ];
    ?>

    <?php
    require("../../components/Logout.php");
    ?>

    <header>
        <img src="../../assets/logo-white.svg" alt="">
    </header>

    <main>
        <nav class="sideNav">
            <?php

            $currentPage = isset($_GET['page']) ? $_GET['page'] : 'user_management'; 

            foreach ($iconArray as $item) {

                $isSelected = ($item['key'] === $currentPage) ? 'selected' : '';
            ?>
                <div class="<?php echo $isSelected; ?>">
                    <a href="?page=<?php echo $item['key']; ?>">
                        <span>
                            <?php echo ($item['text']); ?>
                        </span>
                    </a>
                </div>
            <?php
            }
            ?>
        </nav>

        <section class="content">
            <?php
            switch ($currentPage) {
                case 'user_management':
                    include "../../components/UserManagement.php";
                    break;
                case 'recipe_management':
                    include "../../components/RecipeManagement.php";
                    break;
                case 'recipe_approval':
                    include "../../components/RecipeApproval.php";
                    break;
                default:
                    echo "<h2>Page not found</h2>";
                    break;
            }
            ?>
        </section>
    </main>
</body>

<script src="./main.js" type="module" defer></script>

</html>