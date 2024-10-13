<?php 
require_once("connect.php");
$conn->select_db("recipe-hunt");

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query to get the user by username
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $hashedPassword = $user['password']; 
        
        if (password_verify($password, $hashedPassword)) {
            if(!isset($_COOKIE["user"])){
                setcookie("user", $username, time() + (86400 * 7), "/"); // 86400 = 1 day
            }
            echo json_encode(["status" => "success", "message" => "Login Successful"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid username or password"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid username or password"]);
    }
}
?>
