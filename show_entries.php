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

    // Fetch entries from the database
    $stmt = $conn->prepare("SELECT id, journal_entries, font, color, audio, created_at FROM journal_entries WHERE user_id = ? ORDER BY id DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $entries = [];
    while ($row = $result->fetch_assoc()) {
        $entries[] = $row;
    }

    $stmt->close();
    $conn->close();

    echo json_encode(['success' => true, 'entries' => $entries]);
?>
