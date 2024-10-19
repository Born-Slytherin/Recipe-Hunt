<?php

require_once("createDB.php");

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
    echo "<script>console.log('Error creating user table: ', $conn->error)</script>";
}

$sql = "CREATE TABLE IF NOT EXISTS ingredients (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
)";
if ($conn->query($sql) === TRUE) {
    echo "<script>console.log('Ingredients Table created successfully')</script>";
} else {
    echo "<script>console.log('Error creating Ingredients table: ', $conn->error)</script>";
}

$sql = "CREATE TABLE IF NOT EXISTS recipes (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    steps TEXT NOT NULL,
    tips TEXT,
    cuisine VARCHAR(100) NOT NULL,
    meal VARCHAR(100) NOT NULL,
    servings INT(11) NOT NULL,
    image_url VARCHAR(255),
    created_by INT(11) UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
)";
if ($conn->query($sql) === TRUE) {
    echo "<script>console.log('Recipes table created successfully')</script>";
} else {
    echo "<script>console.log('Error creating Recipes Table: ', $conn->error)</script>";
}

$sql = "CREATE TABLE IF NOT EXISTS recipe_ingredients (
    recipe_id INT(11) UNSIGNED,
    ingredient_id INT(11) UNSIGNED,
    quantity VARCHAR(50),
    PRIMARY KEY (recipe_id, ingredient_id),
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
    FOREIGN KEY (ingredient_id) REFERENCES ingredients(id) ON DELETE CASCADE
)";
if ($conn->query($sql) === TRUE) {
    echo "<script>console.log('Recipe-Ingredients Table created successfully')</script>";
} else {
    echo "<script>console.log('Error creating Recipe-Ingredients Table: ', $conn->error)</script>";
}

$conn->close();
