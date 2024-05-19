const questions = [
  {
    question: "Little interest or pleasure in doing things",
    answers: [
      { text: "Not at all", score: 0 },
      { text: "Several Days", score: 1 },
      { text: "More than half the days", score: 2 },
      { text: "Nearly every day", score: 3 }
    ]
  },
  {
    question: "Feeling down, depressed, or hopeless",
    answers: [
      { text: "Not at all", score: 0 },
      { text: "Several Days", score: 1 },
      { text: "More than half the days", score: 2 },
      { text: "Nearly every day", score: 3 }
    ]
  },
  {
    question: "Trouble falling or staying asleep, or sleeping too much",
    answers: [
      { text: "Not at all", score: 0 },
      { text: "Several Days", score: 1 },
      { text: "More than half the days", score: 2 },
      { text: "Nearly every day", score: 3 }
    ]
  },
  {
    question: "Feeling tired or having little energy",
    answers: [
      { text: "Not at all", score: 0 },
      { text: "Several Days", score: 1 },
      { text: "More than half the days", score: 2 },
      { text: "Nearly every day", score: 3 }
    ]
  },
  {
    question: "Poor appetite or overeating",
    answers: [
      { text: "Not at all", score: 0 },
      { text: "Several Days", score: 1 },
      { text: "More than half the days", score: 2 },
      { text: "Nearly every day", score: 3 }
    ]
  },
  {
    question: "Feeling bad about yourself-or that you are a failure or have let yourself or your family down",
    answers: [
      { text: "Not at all", score: 0 },
      { text: "Several Days", score: 1 },
      { text: "More than half the days", score: 2 },
      { text: "Nearly every day", score: 3 }
    ]
  },
  {
    question: "Trouble concentrating on things, such as reading the newspaper or watching television",
    answers: [
      { text: "Not at all", score: 0 },
      { text: "Several Days", score: 1 },
      { text: "More than half the days", score: 2 },
      { text: "Nearly every day", score: 3 }
    ]
  },
  {
    question: "Moving or speaking so slowly that other people could have noticed? Or the opposite-being so fidgety or restless that you have been moving around a lot more than usual",
    answers: [
      { text: "Not at all", score: 0 },
      { text: "Several Days", score: 1 },
      { text: "More than half the days", score: 2 },
      { text: "Nearly every day", score: 3 }
    ]
  },
  {
    question: "Thoughts that you would be better off dead or of hurting yourself in some way",
    answers: [
      { text: "Not at all", score: 0 },
      { text: "Several Days", score: 1 },
      { text: "More than half the days", score: 2 },
      { text: "Nearly every day", score: 3 }
    ]
  }
];


let currentQuestionIndex = 0;
let scores = Array(questions.length).fill(0);

const questionContainer = document.getElementById('question-container');
const questionElement = document.getElementById('question');
const answerButtonsElement = document.getElementById('answer-buttons');
const prevButton = document.getElementById('prev-btn');
const nextButton = document.getElementById('next-btn');
const submitButton = document.getElementById('submit-btn');
const moodButtonsElement = document.createElement('div');
moodButtonsElement.classList.add('btn-container');

function startQuiz() {
  currentQuestionIndex = 0;
  showQuestion(questions[currentQuestionIndex]);
  prevButton.style.display = 'none';
  submitButton.style.display = 'none';
}

function showQuestion(question) {
  questionElement.innerText = question.question;
  answerButtonsElement.innerHTML = '';
  question.answers.forEach(answer => {
      const button = document.createElement('button');
      button.innerText = answer.text;
      button.classList.add('btn');
      button.addEventListener('click', () => selectAnswer(answer.score));
      answerButtonsElement.appendChild(button);
  });
}

function selectAnswer(score) {
  scores[currentQuestionIndex] = score;
  if (currentQuestionIndex < questions.length - 1) {
      nextQuestion();
  } else {
      showSubmitButton();
  }
}

function nextQuestion() {
  currentQuestionIndex++;
  showQuestion(questions[currentQuestionIndex]);
  prevButton.style.display = currentQuestionIndex > 0 ? 'inline-block' : 'none';
  nextButton.style.display = currentQuestionIndex < questions.length - 1 ? 'inline-block' : 'none';
  submitButton.style.display = currentQuestionIndex === questions.length - 1 ? 'inline-block' : 'none';
}

function prevQuestion() {
  currentQuestionIndex--;
  showQuestion(questions[currentQuestionIndex]);
  prevButton.style.display = currentQuestionIndex > 0 ? 'inline-block' : 'none';
  nextButton.style.display = 'inline-block';
  submitButton.style.display = 'none';
}

function showSubmitButton() {
  nextButton.style.display = 'none';
  submitButton.style.display = 'inline-block';
}

function showScore() {
  resetState();
  let totalScore = scores.reduce((a, b) => a + b, 0);
  let mood = "";
  let path = '';
  if (totalScore <= 5) {
      mood = "Happy";
      path = "moods_happy";
  } else if (totalScore <= 10) {
      mood = "Sad";
      path = "moods_sad";
  } else if (totalScore <= 15) {
      mood = "Anxious";
      path = "moods_anxious";
  } else if (totalScore <= 20) {
      mood = "Angry";
      path = "moods_angry";
  } else if (totalScore <= 25) {
      mood = "Depressed";
      path = "moods_depressed";
  } else {
      mood = "Overwhelmed";
      path = "moods_overwhelmed";
  }

  questionElement.innerHTML = `You seem to be feeling ${mood}.`;
  moodButtonsElement.innerHTML = `
      <button class="btn" onclick="redirect('${path}')">Learn more about feeling ${mood}</button>
      <button class="btn" onclick="redirect('home')">Go to Homepage</button>
  `;
  questionContainer.appendChild(moodButtonsElement);
  storeResult(totalScore, mood);
}

function resetState() {
  answerButtonsElement.innerHTML = '';
  prevButton.style.display = 'none';
  nextButton.style.display = 'none';
  submitButton.style.display = 'none';
}

function redirect(page) {
  window.location.href = `${page}.html`;
}

function storeResult(score, mood) {
  fetch('store_result.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json'
      },
      body: JSON.stringify({ score, mood })
  }).then(response => response.json())
    .then(data => console.log(data))
    .catch(error => console.error('Error:', error));
}

prevButton.addEventListener('click', prevQuestion);
nextButton.addEventListener('click', nextQuestion);
submitButton.addEventListener('click', showScore);

startQuiz();
