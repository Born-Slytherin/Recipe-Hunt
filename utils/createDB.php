<?php

require_once("connect.php");
// Create the database
$sql = "CREATE DATABASE IF NOT EXISTS `recipe-hunt`";

if ($conn->query($sql) === TRUE) {
    echo "<script>console.log('Database created successfully')</script>";
} else {
    echo "<script>console.log('Error creating Database: ', $conn->error)</script>";
}

// Select the database
$conn->select_db('recipe-hunt');
