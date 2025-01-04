<?php
require_once("../../utils/connect.php");
$conn->select_db('recipe-hunt');

$query = "SELECT recipes.*, users.username AS username, users.email AS user_email
          FROM recipes
          JOIN users ON recipes.created_by = users.id
          WHERE recipes.isApproved = 0";

$result = mysqli_query($conn, $query);

$recipes = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($recipe = mysqli_fetch_assoc($result)) {
        $recipeId = $recipe['id'];

        // Fetch ingredients
        $ingredientsQuery = "SELECT ingredients.name, recipe_ingredients.quantity
                             FROM ingredients
                             JOIN recipe_ingredients ON ingredients.id = recipe_ingredients.ingredient_id
                             WHERE recipe_ingredients.recipe_id = $recipeId";
        $ingredientsResult = mysqli_query($conn, $ingredientsQuery);
        $ingredients = [];
        while ($ingredient = mysqli_fetch_assoc($ingredientsResult)) {
            $ingredients[] = $ingredient;
        }

        // Fetch steps
        $stepsQuery = "SELECT step_order, description FROM recipe_steps WHERE recipe_id = $recipeId ORDER BY step_order";
        $stepsResult = mysqli_query($conn, $stepsQuery);
        $steps = [];
        while ($step = mysqli_fetch_assoc($stepsResult)) {
            $steps[] = $step;
        }

        // Fetch tips
        $tipsQuery = "SELECT tip FROM recipe_tips WHERE recipe_id = $recipeId";
        $tipsResult = mysqli_query($conn, $tipsQuery);
        $tips = [];
        while ($tip = mysqli_fetch_assoc($tipsResult)) {
            $tips[] = $tip;
        }

        $recipe['ingredients'] = $ingredients;
        $recipe['steps'] = $steps;
        $recipe['tips'] = $tips;

        $recipes[] = $recipe;
    }
}

// Approve recipe
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['approve_id'])) {
    $approveId = intval($_POST['approve_id']); // Ensure the ID is an integer

    $approveQuery = "UPDATE recipes SET isApproved = 1 WHERE id = $approveId";
    if (mysqli_query($conn, $approveQuery)) {
        header("Location: index.php?page=recipe_approval");
        exit();
    } else {
        echo "Error approving recipe: " . mysqli_error($conn);
    }
}

$conn->close();
?>

<div class="recipeApprovalContainer">
    <?php
    if (!empty($recipes)) {
        foreach ($recipes as $recipe) {
            echo "<form method='POST' class='recipeItem'>";

            echo '<h3>' . htmlspecialchars($recipe['title']) . '</h3>';

            echo '<div class="recipeItemGridWrapper">';
            // Display recipe image
            echo '<div class="recipeImageContainer">';
            if (!empty($recipe['image_url'])) {
                // Check if the image is stored as a data URL
                if (strpos($recipe['image_url'], 'data:image/') === 0) {
                    echo '<img src="' . $recipe['image_url'] . '" alt="' . htmlspecialchars($recipe['title']) . '" class="recipeImage">';
                } else {
                    echo '<p>Invalid image data.</p>';
                }
            } else {
                echo '<p>No image available.</p>';
            }
            echo '</div>';


            echo '<div class="dataWrapper">';
            echo '<p><strong>Submitted by:</strong> ' . htmlspecialchars($recipe['username']) . ' (' . htmlspecialchars($recipe['user_email']) . ')</p>';

            echo '<h4>Ingredients:</h4><ul>';
            foreach ($recipe['ingredients'] as $ingredient) {
                echo '<li>' . htmlspecialchars($ingredient['name']) . ' - ' . htmlspecialchars($ingredient['quantity']) . '</li>';
            }
            echo '</ul>';

            echo '<h4>Steps:</h4><ol>';
            foreach ($recipe['steps'] as $step) {
                echo '<li>' . htmlspecialchars($step['description']) . '</li>';
            }
            echo '</ol>';

            echo '<h4>Tips:</h4><ul>';
            foreach ($recipe['tips'] as $tip) {
                echo '<li>' . htmlspecialchars($tip['tip']) . '</li>';
            }
            echo '</ul>';


            echo '</div>';
            echo '</div>';

            echo '<input type="hidden" name="approve_id" value="' . $recipe['id'] . '">';
            echo '<button type="submit" class="approveButton">Approve</button>';
            echo '</form>';
        }
    } else {
        echo '<p class="noApprovedrecipes">No unapproved recipes found.</p>';
    }
    ?>
</div>

<style>
    .recipeImageContainer {
        display: grid;
        place-content: center;
        border: 1px solid gray;
        border-radius: 10px;
        height: 300px;
    }

    .recipeApprovalContainer {
        width: 100%;
        min-height: 80vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 18px;
        padding: 20px;
        justify-content: center;

        & .noApprovedrecipes {
            color: #676767;
        }
    }

    .recipeItem {
        width: 100%;
        border: 1px solid #676767;
        margin-bottom: 15px;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
        list-style-position: inside;
    }

    .recipeItem:hover {
        transform: translateY(-5px);
    }

    .recipeItem h3 {
        color: white;
        font-size: 36px;
        margin-bottom: 15px;
    }

    .recipeItemGridWrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .recipeImageContainer {
        width: 100%;
    }

    .recipeImage {
        width: 100%;
        max-height: 300px;
        object-fit: cover;
        border-radius: 8px;
    }

    .dataWrapper {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .approveButton {
        margin-top: 10px;
        padding: 8px 16px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .approveButton:hover {
        background-color: #45a049;
    }
</style>