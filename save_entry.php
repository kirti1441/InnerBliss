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

if (isset($data['journal_entries']) && isset($data['font']) && isset($data['color'])) {
    $journal_entries = $data['journal_entries'];
    $font = $data['font'];
    $color = $data['color'];
    $audio = $data['audio'];

    // Insert the entry into the database
    $stmt = $conn->prepare("INSERT INTO journal_entries (user_id, journal_entries, font, color, audio) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $journal_entries, $font, $color, $audio);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'entry' => [
            'id' => $stmt->insert_id,
            'timestamp' => date("Y-m-d H:i:s"),
            'journal_entries' => $journal_entries,
            'font' => $font,
            'color' => $color,
            'audio' => $audio
        ]]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save entry']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
}

$conn->close();
?>
