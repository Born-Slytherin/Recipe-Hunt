<?php

require_once("./connect.php");
$conn->select_db('recipe-hunt');

$input = json_decode(file_get_contents('php://input'), true);
$userName = $input['userName'] ?? null;

if (!$userName) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid or missing username.']);
    exit;
}

// Sanitize input
$userName = htmlspecialchars(strip_tags($userName), ENT_QUOTES, 'UTF-8');

// Fetch user ID
$userQuery = "SELECT id FROM users WHERE username = '$userName'";
$userResult = mysqli_query($conn, $userQuery);

if ($userResult && mysqli_num_rows($userResult) > 0) {
    $userId = mysqli_fetch_assoc($userResult)['id'];

    // Delete all related data
    $conn->query("DELETE FROM recipe_ingredients WHERE recipe_id IN (SELECT id FROM recipes WHERE created_by = $userId)");
    $conn->query("DELETE FROM recipe_steps WHERE recipe_id IN (SELECT id FROM recipes WHERE created_by = $userId)");
    $conn->query("DELETE FROM recipe_tips WHERE recipe_id IN (SELECT id FROM recipes WHERE created_by = $userId)");
    $conn->query("DELETE FROM recipes WHERE created_by = $userId");

    // Delete the user
    $deleteUserQuery = "DELETE FROM users WHERE id = $userId";
    $deleteResult = mysqli_query($conn, $deleteUserQuery);

    if ($deleteResult) {
        echo json_encode(['status' => 200, 'message' => 'User and related data deleted successfully.']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to delete user: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 404, 'message' => 'User not found.']);
}

mysqli_close($conn);
?>
