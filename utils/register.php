<?php

require_once("connect.php");
$conn->select_db("recipe-hunt");

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    if ($password !== $confirmPassword) {
        echo json_encode(["status" => "error", "message" => "Passwords do not match."]);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check for existing username or email
    $checkUsername = "SELECT * FROM users WHERE username = '$username'";
    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    
    $resultUsername = mysqli_query($conn, $checkUsername);
    $resultEmail = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($resultUsername) > 0) {
        echo json_encode(["status" => "error", "message" => "Username already exists."]);
    } else if (mysqli_num_rows($resultEmail) > 0) {
        echo json_encode(["status" => "error", "message" => "Email already exists."]);
    } else {
        $sql = "INSERT INTO users (username, fullname, email, password) VALUES ('$username', '$fullname', '$email', '$hashedPassword')";
        
        if (mysqli_query($conn, $sql)) {
            echo json_encode(["status" => "success", "message" => "Registration successful."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . mysqli_error($conn)]);
        }
    }
}
