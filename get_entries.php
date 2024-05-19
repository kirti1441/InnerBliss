<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['entries' => []]);
    exit;
}

$user_id = $_SESSION['user_id'];
$conn = new mysqli('localhost', 'root', '', 'journaling_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT id, text, font, color, audio, timestamp FROM journal_entries WHERE user_id = ? ORDER BY timestamp DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$entries = [];
while ($row = $result->fetch_assoc()) {
    $entries[] = $row;
}

echo json_encode(['entries' => $entries]);

$stmt->close();
$conn->close();
?>
