document.addEventListener("DOMContentLoaded", function() {
  const saveButton = document.getElementById("saveBtn");
  const saveAudioButton = document.getElementById("saveAudioBtn");
  const fontSelect = document.getElementById("fontSelect");
  const colorSelect = document.getElementById("colorSelect");
  const startRecordingButton = document.getElementById("startRecording");
  const stopRecordingButton = document.getElementById("stopRecording");
  const recordedAudio = document.getElementById("recordedAudio");
  let mediaRecorder;

  // Save entry
  saveButton.addEventListener("click", saveEntry);

  // Save audio
  saveAudioButton.addEventListener("click", saveEntry);

  // Function to save entry (both text and audio)
  function saveEntry() {
    const entryTextarea = document.getElementById("entry");
    const fontSelect = document.getElementById("fontSelect");
    const colorSelect = document.getElementById("colorSelect");
    const recordedAudio = document.getElementById("recordedAudio");

    const entryText = entryTextarea.value;
    if (entryText.trim() !== "") {
        const entryData = {
            journal_entries: entryText,
            font: fontSelect.value,
            color: colorSelect.value,
            audio: recordedAudio.src
        };

        fetch('save_entry.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(entryData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Entry saved successfully!");
                showEntries();
                // You may want to refresh the entries list or clear the textarea
            } else {
                alert("Failed to save entry: " + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    } else {
        alert("Please write something before saving!");
    }
  }
  
  const entriesContainer = document.getElementById("entries");
  const toggleEntriesButton = document.getElementById("toggleEntries");

  toggleEntriesButton.addEventListener("click", showEntries);

  function showEntries() {
      fetch('show_entries.php')
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  displayEntries(data.entries);
              } else {
                  alert("Failed to fetch entries: " + data.message);
              }
          })
          .catch(error => {
              console.error('Error:', error);
          });
  };

  function displayEntries(entries) {
      entriesContainer.innerHTML = ''; // Clear existing entries
      entries.forEach(entry => {
          const entryDiv = document.createElement("div");
          entryDiv.classList.add("entry-item");
          entryDiv.innerHTML = `
              <p><strong>${entry.created_at}</strong></p>
              <p style="font-family: ${entry.font}; color: ${entry.color};">${entry.journal_entries}</p>
              ${entry.audio ? `<audio controls><source src="${entry.audio}" type="audio/mpeg"></audio>` : ""}
              <button class="btn btn-danger button_pad delete-entry" data-id="${entry.id}">Delete</button>
          `;
          entriesContainer.append(entryDiv);

          // Attach event listener to delete button
          const deleteButton = entryDiv.querySelector(".delete-entry");
          deleteButton.addEventListener("click", function() {
              if (confirm("Are you sure you want to delete this entry?")) {
                  deleteEntry(entry.id, entryDiv);
              }
          });
      });
  }

  function deleteEntry(entryId, entryDiv) {
      fetch('delete_entry.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json'
          },
          body: JSON.stringify({ id: entryId })
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              entriesContainer.removeChild(entryDiv);
          } else {
              alert("Failed to delete entry: " + data.message);
          }
      })
      .catch(error => {
          console.error('Error:', error);
      });
  }

  // Change font
  fontSelect.addEventListener("change", function() {
    entryTextarea.style.fontFamily = fontSelect.value;
  });

  // Change text color
  colorSelect.addEventListener("input", function() {
    entryTextarea.style.color = colorSelect.value;
  });

  // Start audio recording
  startRecordingButton.addEventListener("click", function() {
    navigator.mediaDevices.getUserMedia({ audio: true })
      .then(function(stream) {
        mediaRecorder = new MediaRecorder(stream);
        startRecordingButton.disabled = true;
        stopRecordingButton.disabled = false;
        chunks = [];
        mediaRecorder.ondataavailable = function(event) {
          chunks.push(event.data);
        }
        mediaRecorder.onstop = function() {
          const blob = new Blob(chunks, { type: 'audio/webm' });
          const audioURL = URL.createObjectURL(blob);
          recordedAudio.src = audioURL;
          recordedAudio.style.display = "block";
        }
        mediaRecorder.start();
      })
      .catch(function(err) {
        console.error('Error accessing microphone', err);
      });
  });

  // Stop audio recording
  stopRecordingButton.addEventListener("click", function() {
    mediaRecorder.stop();
    startRecordingButton.disabled = false;
    stopRecordingButton.disabled = true;
  });
});
