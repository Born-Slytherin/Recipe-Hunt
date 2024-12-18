<?php

require_once("createDB.php");

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    fullname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "<script>console.log('Users table created successfully')</script>";
} else {
    echo "<script>console.log('Error creating users table: ', $conn->error)</script>";
}

// Create ingredients table
$sql = "CREATE TABLE IF NOT EXISTS ingredients (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
)";

if ($conn->query($sql) === TRUE) {
    echo "<script>console.log('Ingredients table created successfully')</script>";
} else {
    echo "<script>console.log('Error creating ingredients table: ', $conn->error)</script>";
}

// Create recipes table with isGenerated field
$sql = "CREATE TABLE IF NOT EXISTS recipes (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    cuisine VARCHAR(100) NOT NULL,
    meal VARCHAR(100) NOT NULL,
    servings INT(11) NOT NULL,
    image_url LONGTEXT,
    created_by INT(11) UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    isGenerated BOOLEAN DEFAULT FALSE,
    vegetarian BOOLEAN DEFAULT FALSE,
    isApproved BOOLEAN DEFAULT FALSE,   
    FOREIGN KEY (created_by) REFERENCES users(id)
)";

if ($conn->query($sql) === TRUE) {
    echo "<script>console.log('Recipes table created successfully')</script>";
} else {
    echo "<script>console.log('Error creating recipes table: ', $conn->error)</script>";
}


// Create recipe_steps table
$sql = "CREATE TABLE IF NOT EXISTS recipe_steps (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT(11) UNSIGNED,
    step_order INT(11) NOT NULL,
    description TEXT NOT NULL,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    echo "<script>console.log('Recipe Steps table created successfully')</script>";
} else {
    echo "<script>console.log('Error creating recipe_steps table: ', $conn->error)</script>";
}

// Create recipe_tips table
$sql = "CREATE TABLE IF NOT EXISTS recipe_tips (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT(11) UNSIGNED,
    tip TEXT NOT NULL,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    echo "<script>console.log('Recipe Tips table created successfully')</script>";
} else {
    echo "<script>console.log('Error creating recipe_tips table: ', $conn->error)</script>";
}

// Create recipe_ingredients table
$sql = "CREATE TABLE IF NOT EXISTS recipe_ingredients (
    recipe_id INT(11) UNSIGNED,
    ingredient_id INT(11) UNSIGNED,
    quantity VARCHAR(50),
    PRIMARY KEY (recipe_id, ingredient_id),
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
    FOREIGN KEY (ingredient_id) REFERENCES ingredients(id) ON DELETE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    echo "<script>console.log('Recipe-Ingredients table created successfully')</script>";
} else {
    echo "<script>console.log('Error creating recipe_ingredients table: ', $conn->error)</script>";
}

$conn->close();
