<?php
$servername = "apache";
$username = "root";
$password = "12345";
$dbname = "mood_tracker";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$mood = $_POST['mood'];
$note = $_POST['note'];
$dateTime = $_POST['dateTime'];


$sql = "INSERT INTO moods (mood, note, dateTime) VALUES ('$mood', '$note', '$dateTime')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
