<?php
require_once("connect.php");
$conn->select_db("recipe-hunt");

$username = $_COOKIE["user"];

$userQuery = "SELECT `id` FROM `users` WHERE `username` = '$username'";
$userResult = mysqli_query($conn, $userQuery);
$userData = mysqli_fetch_assoc($userResult);
$userId = $userData['id'];

$data = file_get_contents("php://input");
$recipeData = json_decode($data, true);

if (!$recipeData) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid JSON data."]);
    exit;
}

$title = $recipeData['title'];
$cuisine = $recipeData['cuisine'];
$meal = $recipeData['meal'];
$servings = (int)$recipeData['servings'];
$image = isset($recipeData['image']) ? $recipeData['image'] : null;

// Prepare and execute insert recipe query
$insertRecipeQuery = "INSERT INTO `recipes` (`title`, `cuisine`, `meal`, `servings`, `image_url`, `created_by`,`isGenerated`) 
                      VALUES ('$title', '$cuisine', '$meal', $servings, ".($image ? "'$image'" : "NULL").", $userId , true)";

if (mysqli_query($conn, $insertRecipeQuery)) {
    $recipeId = mysqli_insert_id($conn);

    // Insert steps into the recipe_steps table
    foreach ($recipeData['steps'] as $index => $step) {
        $step = $step;
        $insertStepQuery = "INSERT INTO `recipe_steps` (`recipe_id`, `step_order`, `description`) 
                            VALUES ($recipeId, ".($index + 1).", '$step')";
        mysqli_query($conn, $insertStepQuery);
    }

    // Insert tips into the recipe_tips table
    if (isset($recipeData['tips']) && is_array($recipeData['tips'])) {
        foreach ($recipeData['tips'] as $tip) {
            $tip = $tip;
            $insertTipQuery = "INSERT INTO `recipe_tips` (`recipe_id`, `tip`) 
                               VALUES ($recipeId, '$tip')";
            mysqli_query($conn, $insertTipQuery);
        }
    }

    // Insert ingredients and link to recipe
    foreach ($recipeData['ingredients'] as $ingredient) {
        $ingredientName = $ingredient['name'];
        $quantity = $ingredient['quantity'];

        // Insert ingredient and link to recipe
        $insertIngredientQuery = "INSERT INTO `ingredients` (`name`) 
                                  VALUES ('$ingredientName') 
                                  ON DUPLICATE KEY UPDATE `id`=LAST_INSERT_ID(`id`)";
        mysqli_query($conn, $insertIngredientQuery);
        $ingredientId = mysqli_insert_id($conn);

        $linkIngredientQuery = "INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_id`, `quantity`) 
                                VALUES ($recipeId, $ingredientId, '$quantity')";
        mysqli_query($conn, $linkIngredientQuery);
    }

    http_response_code(200);
    echo json_encode(["message" => "Recipe data saved successfully."]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to save recipe.", "details" => mysqli_error($conn)]);
}

mysqli_close($conn);
?>
