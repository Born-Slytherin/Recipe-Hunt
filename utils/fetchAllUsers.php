<?php
require('connect.php');
$conn->select_db('recipe-hunt');

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT * FROM users WHERE role='user'";

if ($searchQuery) {
    $searchQuery = "%$searchQuery%";
    $query .= " AND username LIKE ?";
}

$stmt = $conn->prepare($query);

if ($searchQuery) {
    $stmt->bind_param("s", $searchQuery);
}

$stmt->execute();
$result = $stmt->get_result();

$users = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    echo json_encode(['status' => 200, 'users' => $users]);
} else {
    echo json_encode(['status' => 404, 'message' => 'No users found.']);
}

$stmt->close();
$conn->close();
