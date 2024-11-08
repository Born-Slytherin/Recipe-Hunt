<?php
require_once('./connect.php');
$conn->select_db('recipe-hunt');

try {
    $query = "SELECT * FROM `recipes`";
    $result = mysqli_query($conn , $query);

    if (!$result) {
        throw new Exception("Result not found!");
    }

    $recipes = [];
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }

    echo json_encode([
        "status" => 200,
        "message" => "Recipes fetched successfully",
        "data" => $recipes
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => 404,
        "success" => false,
        "message" => "Failed to fetch recipes: " . $e->getMessage()
    ]);
}

$conn->close();
?>
