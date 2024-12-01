<?php
require_once('./connect.php');
$conn->select_db('recipe-hunt');

$query = "SELECT * FROM recipes WHERE isApproved = false";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {

    $recipes = [];

    while ($recipe = mysqli_fetch_assoc($result)) {
        $recipes[] = $recipe;
    }

    echo json_encode([
        "status" => 200,
        "success" => true,
        "data" => $recipes
    ]);
} else {
    echo json_encode([
        "status" => 404,
        "success" => false,
        "message" => "No unapproved recipes found."
    ]);
}

$conn->close();
