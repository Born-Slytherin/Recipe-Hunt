<?php 

    require_once './connect.php';

    $createTableSql = "CREATE TABLE IF NOT EXISTS users (
                        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(30) NOT NULL,
                        email VARCHAR(50) UNIQUE NOT NULL,
                        password VARCHAR(255) NOT NULL
                    )";

    if (mysqli_query($dbcon, $createTableSql)) {
        echo "Table 'users' created successfully";
    } else {
        echo "Error creating table: " . mysqli_error($dbcon);
    }
?>