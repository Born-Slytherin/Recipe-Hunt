<?php
require_once("connect.php");
$conn->select_db("recipe-hunt");

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $hashedPassword = $user['password'];

        // Check if the admin password is stored as plain text
        if ($user['role'] === 'admin') {
            // If it's plain text, compare directly (not recommended for production)
            if ($password === $hashedPassword) {
                // Set cookie for admin
                if (!isset($_COOKIE["user"])) {
                    setcookie("user", $username, time() + (86400 * 7), "/");
                }
                echo json_encode(["status" => "success", "message" => "Login Successful", "redirect" => "../admin/index.php"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid username or password"]);
            }
        } else {
            // For non-admin users, use password_verify for hashed passwords
            if (password_verify($password, $hashedPassword)) {
                if (!isset($_COOKIE["user"])) {
                    setcookie("user", $username, time() + (86400 * 7), "/");
                }
                echo json_encode(["status" => "success", "message" => "Login Successful", "redirect" => "../home/index.php"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid username or password"]);
            }
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid username or password"]);
    }
}
