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

$title = mysqli_real_escape_string($conn, $recipeData['title']);
$steps = mysqli_real_escape_string($conn, implode(" | ", $recipeData['steps']));
$tips = isset($recipeData['tips']) ? mysqli_real_escape_string($conn, implode(" | ", $recipeData['tips'])) : null;
$cuisine = mysqli_real_escape_string($conn, $recipeData['cuisine']);
$meal = mysqli_real_escape_string($conn, $recipeData['meal']);
$servings = (int)$recipeData['servings'];
$image = $recipeData['image'] ? mysqli_real_escape_string($conn, $recipeData['image']) : null;

// Prepare and execute insert recipe query
$insertRecipeQuery = "INSERT INTO `recipes` (`title`, `steps`, `tips`, `cuisine`, `meal`, `servings`, `image_url`, `created_by`) 
                      VALUES ('$title', '$steps', ".($tips ? "'$tips'" : "NULL").", '$cuisine', '$meal', $servings, ".($image ? "'$image'" : "NULL").", $userId)";

if (mysqli_query($conn, $insertRecipeQuery)) {
    $recipeId = mysqli_insert_id($conn);

    foreach ($recipeData['ingredients'] as $ingredient) {
        $ingredientName = mysqli_real_escape_string($conn, $ingredient['name']);
        $quantity = mysqli_real_escape_string($conn, $ingredient['quantity']);

        // Insert ingredients and link to recipe
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
