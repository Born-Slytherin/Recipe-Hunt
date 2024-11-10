<?php
require("connect.php");
$conn->select_db("recipe-hunt");

$userName = $_COOKIE['user'];

$selectUserIDquery = "SELECT `id` FROM `users` WHERE `username` = '$userName'";

$userIDResult = mysqli_query($conn, $selectUserIDquery);

if ($userIDResult && mysqli_num_rows($userIDResult) > 0) {
    $userData = mysqli_fetch_assoc($userIDResult);
    $userID = $userData['id'];

    echo json_encode([ "status" => 200 ,"data" => $userID]);
}else{
    echo json_encode(["status"=> 404 ,"error" => "User not found"]);
}

?>
