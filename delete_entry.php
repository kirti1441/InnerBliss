<?php
session_start();
include 'db.php'; // This includes the database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Get the posted data
$data = json_decode(file_get_contents("php://input"), true);
$entry_id = $data['id'];

// Delete the entry from the database
$stmt = $conn->prepare("DELETE FROM journal_entries WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $entry_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete entry']);
}

$stmt->close();
$conn->close();
?>
