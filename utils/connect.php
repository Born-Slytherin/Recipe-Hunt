<?php 

    $dbConfig = [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'recipe-hunt',
    ];

    $dbcon = @mysqli_connect($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['database']);

    if (!$dbcon) {
        die("Connection failed: " . mysqli_connect_error());

        $createdb_sql = "CREATE DATABASE IF NOT EXISTS " . $dbConfig['database'];
        $result = mysqli_query($dbcon, $createdb_sql);

        if ($result) {
            echo "Database created successfully";
        } else {
            echo "Error creating database: " . mysqli_error($dbcon);
        }
    } else {
        echo "Connected successfully";
    }
    
?>