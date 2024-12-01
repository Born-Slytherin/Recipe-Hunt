<?php 

require_once("./connect.php");
$conn->select_db('recipe-hunt');

$requestBody = json_decode(file_get_contents('php://input'), true);
$recipeId = $requestBody['recipeId'] ?? null;

if (!$recipeId) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "No recipe ID provided"]);
    exit;
}

$recipeId = intval($recipeId);

mysqli_begin_transaction($conn);

try {

    $deleteStepsQuery = "DELETE FROM recipe_steps WHERE recipe_id = $recipeId";
    $deleteTipsQuery = "DELETE FROM recipe_tips WHERE recipe_id = $recipeId";
    $deleteIngredientsQuery = "DELETE FROM recipe_ingredients WHERE recipe_id = $recipeId";

    mysqli_query($conn, $deleteStepsQuery);
    mysqli_query($conn, $deleteTipsQuery);
    mysqli_query($conn, $deleteIngredientsQuery);

    $deleteRecipeQuery = "DELETE FROM recipes WHERE id = $recipeId";
    $result = mysqli_query($conn, $deleteRecipeQuery);

    if ($result && mysqli_affected_rows($conn) > 0) {
        mysqli_commit($conn); 
        echo json_encode(["status" => 200, "message" => "Recipe deleted successfully"]);
    } else {
        mysqli_rollback($conn);
        http_response_code(404);
        echo json_encode(["status" => "error", "message" => "Recipe not found"]);
    }
} catch (Exception $e) {
    mysqli_rollback($conn);
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Failed to delete recipe: " . $e->getMessage()]);
} finally {
    $conn->close();
}
?>
