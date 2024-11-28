<?php
require('connect.php');
$conn->select_db('recipe-hunt');


$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT * FROM users WHERE role='user'";

if ($searchQuery) {
    $searchQuery = mysqli_real_escape_string($conn, $searchQuery);
    $query .= " AND username LIKE '%$searchQuery%'";
}

$result = mysqli_query($conn, $query);
$users = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    echo json_encode(['status' => 200, 'users' => $users]);
} else {
    echo json_encode(['status' => 404, 'message' => 'No users found.']);
}
