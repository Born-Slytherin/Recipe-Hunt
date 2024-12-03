<?php
require_once('./connect.php');
$conn->select_db('recipe-hunt');

try {
    $query = "
    SELECT 
        r.id AS recipe_id, r.title, r.cuisine, r.meal, r.servings, r.image_url, r.created_by, r.created_at, r.isGenerated, r.vegetarian,
        i.id AS ingredient_id, i.name AS ingredient_name, ri.quantity AS ingredient_quantity,
        rs.id AS step_id, rs.step_order, rs.description AS step_description,
        rt.id AS tip_id, rt.tip
    FROM recipes r
    LEFT JOIN recipe_ingredients ri ON r.id = ri.recipe_id
    LEFT JOIN ingredients i ON ri.ingredient_id = i.id
    LEFT JOIN recipe_steps rs ON r.id = rs.recipe_id
    LEFT JOIN recipe_tips rt ON r.id = rt.recipe_id
    WHERE r.isApproved = TRUE
    ORDER BY r.id, rs.step_order
";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        throw new Exception("Failed to fetch recipes data!");
    }

    $recipes = [];
    while ($row = $result->fetch_assoc()) {
        $recipe_id = $row['recipe_id'];

        if (!isset($recipes[$recipe_id])) {

            $image_base64 = '';
            if (!empty($row['image_url']) && preg_match('/^data:image\/([a-zA-Z]*);base64,/', $row['image_url'])) {
                $image_base64 = $row['image_url'];
            } elseif (file_exists($row['image_url'])) {
                $image_data = file_get_contents($row['image_url']);
                $image_base64 = 'data:image/' . pathinfo($row['image_url'], PATHINFO_EXTENSION) . ';base64,' . base64_encode($image_data);
            }

            $recipes[$recipe_id] = [
                'id' => (int)$row['recipe_id'],
                'title' => $row['title'],
                'vegetarian' => (bool)$row['vegetarian'],
                'cuisine' => $row['cuisine'],
                'meal' => $row['meal'],
                'servings' => (int)$row['servings'],
                'image_url' => $image_base64,
                'created_by' => (int)$row['created_by'],
                'created_at' => $row['created_at'],
                'isGenerated' => (bool)$row['isGenerated'],
                'ingredients' => [],
                'steps' => [],
                'tips' => []
            ];
        }

        // Add unique ingredient
        if ($row['ingredient_id'] && !isset($recipes[$recipe_id]['ingredients'][$row['ingredient_id']])) {
            $recipes[$recipe_id]['ingredients'][$row['ingredient_id']] = [
                'id' => (int)$row['ingredient_id'],
                'name' => $row['ingredient_name'],
                'quantity' => $row['ingredient_quantity']
            ];
        }

        // Add unique step
        if ($row['step_id'] && !isset($recipes[$recipe_id]['steps'][$row['step_id']])) {
            $recipes[$recipe_id]['steps'][$row['step_id']] = [
                'id' => (int)$row['step_id'],
                'order' => (int)$row['step_order'],
                'description' => $row['step_description']
            ];
        }

        // Add unique tip
        if ($row['tip_id'] && !isset($recipes[$recipe_id]['tips'][$row['tip_id']])) {
            $recipes[$recipe_id]['tips'][$row['tip_id']] = [
                'id' => (int)$row['tip_id'],
                'tip' => $row['tip']
            ];
        }
    }

    // If no recipes are found, return an empty array
    if (empty($recipes)) {
        echo json_encode([
            "status" => 200,
            "message" => "No approved recipes found",
            "data" => []
        ]);
    } else {
        // Convert associative arrays to indexed arrays for JSON encoding
        foreach ($recipes as &$recipe) {
            $recipe['ingredients'] = array_values($recipe['ingredients']);
            $recipe['steps'] = array_values($recipe['steps']);
            $recipe['tips'] = array_values($recipe['tips']);
        }
        unset($recipe);

        // Send the response as JSON
        echo json_encode([
            "status" => 200,
            "message" => "Recipes fetched successfully",
            "data" => array_values($recipes)
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        "status" => 404,
        "success" => false,
        "message" => "Failed to fetch recipes: " . $e->getMessage()
    ]);
}

$conn->close();