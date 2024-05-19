document.addEventListener('DOMContentLoaded', () => {
    const moodButtons = document.querySelectorAll('.mood-btn');
    const submitButton = document.getElementById('submit-btn');
    const moodNote = document.getElementById('mood-note');

    
    $('#calendar').fullCalendar({
        events: '/get_moods.php', 
        eventColor: '#81c784'
    });

    
    const ctx = document.getElementById('line-graph').getContext('2d');
    let moodChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Mood Over Time',
                data: [],
                backgroundColor: 'rgba(129, 199, 132, 0.2)',
                borderColor: 'rgba(129, 199, 132, 1)',
                borderWidth: 1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day'
                    },
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Mood Level'
                    },
                    min: 0,
                    max: 5
                }
            }
        }
    });

    moodButtons.forEach(button => {
        button.addEventListener('click', () => {
            moodButtons.forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
        });
    });

    submitButton.addEventListener('click', () => {
        const selectedMood = document.querySelector('.mood-btn.selected');
        if (selectedMood) {
            const mood = selectedMood.dataset.mood;
            const note = moodNote.value.trim();
            const dateTime = new Date().toISOString();
            
            
            $.ajax({
                url: '/save_mood.php',
                method: 'POST',
                data: {
                    mood: mood,
                    note: note,
                    dateTime: dateTime
                },
                success: function() {
                    moodNote.value = '';
                    moodButtons.forEach(btn => btn.classList.remove('selected'));
                    
                    
                    $('#calendar').fullCalendar('refetchEvents');
                    fetchMoodData();
                }
            });
        } else {
            alert('Please select a mood before submitting.');
        }
    });

    const fetchMoodData = () => {
        $.ajax({
            url: '/get_moods.php',
            method: 'GET',
            success: function(data) {
                const parsedData = JSON.parse(data);
                const labels = parsedData.map(entry => entry.date);
                const moodLevels = parsedData.map(entry => mapMoodToLevel(entry.mood));

                moodChart.data.labels = labels;
                moodChart.data.datasets[0].data = moodLevels;
                moodChart.update();
            }
        });
    };

    const mapMoodToLevel = (mood) => {
        const moodLevels = {
            happy: 5,
            relaxed: 4,
            anxious: 3,
            sad: 2,
            angry: 1
        };
        return moodLevels[mood] || 0;
    };

    fetchMoodData();
});
