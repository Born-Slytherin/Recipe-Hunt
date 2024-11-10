<?php
require_once("connect.php");
$conn->select_db("recipe-hunt");

if (!isset($_COOKIE["user"])) {
    http_response_code(401);
    echo json_encode(["error" => "User not authenticated."]);
    exit;
}

$username = $_COOKIE["user"];

$userQuery = "SELECT `id` FROM `users` WHERE `username` = ?";
$userStmt = $conn->prepare($userQuery);
$userStmt->bind_param("s", $username);
$userStmt->execute();
$userResult = $userStmt->get_result();
$userData = $userResult->fetch_assoc();

if (!$userData) {
    http_response_code(401);
    echo json_encode(["error" => "Invalid user."]);
    exit;
}

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
$image = $recipeData['image'];
$vegetarian = $recipeData['vegetarian'];

$insertRecipeQuery = "INSERT INTO `recipes`(`title`, `cuisine`, `meal`, `servings`, `image_url`, `created_by`, `isGenerated`, `vegetarian`) VALUES (?, ?, ?, ?, ?, ?,1, ?)";
$insertRecipeStmt = $conn->prepare($insertRecipeQuery);
$insertRecipeStmt->bind_param("sssisss", $title, $cuisine, $meal, $servings, $image, $userId, $vegetarian);

if ($insertRecipeStmt->execute()) {
    $recipeId = $conn->insert_id;

    // Insert steps
    $insertStepQuery = "INSERT INTO `recipe_steps` (`recipe_id`, `step_order`, `description`) VALUES (?, ?, ?)";
    $insertStepStmt = $conn->prepare($insertStepQuery);
    $insertStepStmt->bind_param("iis", $recipeId, $stepOrder, $step);

    foreach ($recipeData['steps'] as $index => $step) {
        $stepOrder = $index + 1;
        $insertStepStmt->execute();
    }

    // Insert tips
    if (isset($recipeData['tips']) && is_array($recipeData['tips'])) {
        $insertTipQuery = "INSERT INTO `recipe_tips` (`recipe_id`, `tip`) VALUES (?, ?)";
        $insertTipStmt = $conn->prepare($insertTipQuery);
        $insertTipStmt->bind_param("is", $recipeId, $tip);

        foreach ($recipeData['tips'] as $tip) {
            $insertTipStmt->execute();
        }
    }

    // Insert ingredients
    $insertIngredientQuery = "INSERT INTO `ingredients` (`name`) VALUES (?) ON DUPLICATE KEY UPDATE `id`=LAST_INSERT_ID(`id`)";
    $insertIngredientStmt = $conn->prepare($insertIngredientQuery);
    $insertIngredientStmt->bind_param("s", $ingredientName);

    $linkIngredientQuery = "INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_id`, `quantity`) VALUES (?, ?, ?)";
    $linkIngredientStmt = $conn->prepare($linkIngredientQuery);
    $linkIngredientStmt->bind_param("iis", $recipeId, $ingredientId, $quantity);

    foreach ($recipeData['ingredients'] as $ingredient) {
        $ingredientName = $ingredient['name'];
        $quantity = $ingredient['quantity'];

        $insertIngredientStmt->execute();
        $ingredientId = $conn->insert_id;

        $linkIngredientStmt->execute();
    }

    http_response_code(200);
    echo json_encode(["message" => "Recipe data saved successfully."]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to save recipe.", "details" => $conn->error]);
}

$conn->close();
