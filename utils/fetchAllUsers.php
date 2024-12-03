<?php
require('connect.php');
$conn->select_db('recipe-hunt');

$query = "SELECT * FROM users WHERE role='user'";

$stmt = $conn->prepare($query);

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
