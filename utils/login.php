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

        if ($user['role'] === 'admin') {

            if ($password === $hashedPassword) {
                if (!isset($_COOKIE["user"])) {
                    setcookie("user", $username, time() + (86400 * 7), "/");
                }
                echo json_encode(["status" => "success", "message" => "Login Successful", "redirect" => "../admin/index.php"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid username or password"]);
            }
        } else {

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
