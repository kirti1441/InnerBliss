<?php
$servername = "apache";
$username = "root";
$password = "12345";
$dbname = "mood_tracker";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT mood, note, dateTime FROM moods";
$result = $conn->query($sql);

$moods = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $moods[] = [
            'mood' => $row['mood'],
            'note' => $row['note'],
            'date' => $row['dateTime']
        ];
    }
}

echo json_encode($moods);

$conn->close();
?>
