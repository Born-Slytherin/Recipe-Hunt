<?php

header('Content-Type: application/json');
require('connect.php');

$conn->select_db('recipe-hunt');

$username = $_COOKIE['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $cuisine = $_POST['cuisine'];
    $meal = $_POST['meal'];
    $servings = (int) $_POST['servings'];
    $steps = $_POST['step'] ?? [];
    $tips = $_POST['tip'] ?? [];
    $ingredients = $_POST['ingredient'] ?? [];
    $quantities = $_POST['quantity'] ?? [];

    // Handle Image Upload as BLOB
    $image_data = null;  // Initialize image_data

    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        
        $image_tmp_name = $_FILES['thumbnail']['tmp_name'];
        $image_name = basename($_FILES['thumbnail']['name']);
        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        // Ensure only image files are uploaded
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($image_ext, $allowed_extensions)) {
            // Read the image file as binary data
            $image_data = file_get_contents($image_tmp_name);

            if ($image_data === false) {
                echo json_encode(['success' => false, 'message' => 'Error reading image file']);
                exit;
            }

            // Debugging: Check if image data is being read properly
            // echo json_encode(['success' => true, 'message' => 'Image data read successfully']);
            // exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid image file type']);
            exit;
        }
    }

    // Fetch the user_id from the users table using the username
    $query = "SELECT id FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $user_id = $user['id'];  // Get the user_id
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found']);
        exit;
    }

    $conn->begin_transaction();

    try {
        // Insert the recipe along with the created_by field and image_url as BLOB
        $query = "INSERT INTO recipes (title, cuisine, meal, servings, image_url, created_by) 
                  VALUES ('$title', '$cuisine', '$meal', $servings, ?, $user_id)";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception('Prepare failed: ' . $conn->error);
        }

        // Debugging: Check if the prepared statement is ready
        // echo json_encode(['success' => true, 'message' => 'Prepared statement is ready']);
        // exit;

        $stmt->bind_param("b", $image_data);  // "b" for BLOB

        if (!$stmt->execute()) {
            throw new Exception('Error inserting recipe: ' . $stmt->error);
        }
        $recipe_id = $conn->insert_id;

        // Debugging: Check if recipe was inserted successfully
        // echo json_encode(['success' => true, 'message' => 'Recipe inserted with ID: ' . $recipe_id]);
        // exit;

        // Insert steps
        foreach ($steps as $order => $description) {
            $step_order = $order + 1;
            $query = "INSERT INTO recipe_steps (recipe_id, step_order, description) 
                      VALUES ($recipe_id, $step_order, '$description')";
            if (!mysqli_query($conn, $query)) {
                throw new Exception('Error inserting steps: ' . mysqli_error($conn));
            }
        }

        // Insert tips
        foreach ($tips as $tip) {
            $query = "INSERT INTO recipe_tips (recipe_id, tip) 
                      VALUES ($recipe_id, '$tip')";
            if (!mysqli_query($conn, $query)) {
                throw new Exception('Error inserting tips: ' . mysqli_error($conn));
            }
        }

        // Insert ingredients
        foreach ($ingredients as $index => $ingredient) {
            $quantity = $quantities[$index];

            $query = "INSERT INTO ingredients (name) 
                      VALUES ('$ingredient') 
                      ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)";
            if (!mysqli_query($conn, $query)) {
                throw new Exception('Error inserting ingredients: ' . mysqli_error($conn));
            }
            $ingredient_id = $conn->insert_id;

            $query = "INSERT INTO recipe_ingredients (recipe_id, ingredient_id, quantity) 
                      VALUES ($recipe_id, $ingredient_id, '$quantity')";
            if (!mysqli_query($conn, $query)) {
                throw new Exception('Error linking recipe ingredients: ' . mysqli_error($conn));
            }
        }

        // Commit transaction
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Recipe added successfully']);
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
}

?>
