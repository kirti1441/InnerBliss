<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inner Bliss Journal</title>
  <link rel="stylesheet" href="journaling.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <header>
    <h1>Inner Bliss Journal</h1>
  </header>
  <div class="container">
    <div class="entry-controls">
      <div class="text-controls">
        <label for="fontSelect" class="form-label">Choose Font:</label>
        <select class="form-control" id="fontSelect">
          <option value="Arial">Arial</option>
          <option value="Times New Roman">Times New Roman</option>
          <option value="Courier New">Courier New</option>
        </select>
        <label for="colorSelect" class="form-label">Choose Text Color:</label>
        <input type="color" id="colorSelect" class="form-control">
      </div>
      <div class="audio-controls">
        <button class="btn btn-light" id="startRecording">Start Recording</button>
        <button class="btn btn-light" id="stopRecording" disabled>Stop Recording</button>
        <audio id="recordedAudio" controls style="display: none; margin-top: 20px; width: 100%;"></audio>
      </div>
    </div>
    <textarea class="shadow-lg p-3 mb-5 bg-body-tertiary rounded" id="entry" placeholder="Write your entry here..."></textarea>
    <div class="additional-controls">
      <button class="btn btn-light" id="saveBtn">Save Entry</button>
      <button class="btn btn-light" id="saveAudioBtn">Save Audio</button>
      <button class="btn btn-light" id="toggleEntries">Show Previous Entries</button>
    </div>
    <div id="entries" class="entry-container"></div>
  </div>
  <script src="journaling.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
