const questions = [
  { question: "Which language runs directly in most web browsers?", answers: ["Java", "JavaScript", "C", "SQL"], correct: 1 },
  { question: "Which HTML element creates a hyperlink?", answers: ["<link>", "<a>", "<href>", "<url>"], correct: 1 },
  { question: "Which SQL command reads records?", answers: ["GET", "OPEN", "SELECT", "READ"], correct: 2 },
  { question: "Which symbol starts a PHP variable?", answers: ["#", "$", "@", "&"], correct: 1 },
  { question: "Which Java keyword creates an object?", answers: ["make", "new", "class", "object"], correct: 1 }
];

let current = 0;
let score = 0;
let answered = false;

const questionEl = document.getElementById("question");
const answersEl = document.getElementById("answers");
const progressEl = document.getElementById("progress");
const feedbackEl = document.getElementById("feedback");
const nextButton = document.getElementById("next");
const resultEl = document.getElementById("result");
const restartButton = document.getElementById("restart");

function showQuestion() {
  answered = false;
  const item = questions[current];
  progressEl.textContent = `Question ${current + 1} of ${questions.length}`;
  questionEl.textContent = item.question;
  feedbackEl.textContent = "";
  nextButton.disabled = true;
  answersEl.replaceChildren();

  item.answers.forEach((answer, index) => {
    const button = document.createElement("button");
    button.textContent = answer;
    button.addEventListener("click", () => chooseAnswer(index));
    answersEl.appendChild(button);
  });
}

function chooseAnswer(index) {
  if (answered) return;
  answered = true;
  const correct = questions[current].correct;
  if (index === correct) {
    score++;
    feedbackEl.textContent = "Correct!";
  } else {
    feedbackEl.textContent = `Not quite. Correct answer: ${questions[current].answers[correct]}`;
  }
  [...answersEl.children].forEach(button => button.disabled = true);
  nextButton.disabled = false;
}

nextButton.addEventListener("click", () => {
  current++;
  if (current < questions.length) {
    showQuestion();
  } else {
    questionEl.textContent = "Quiz completed!";
    progressEl.textContent = "";
    answersEl.replaceChildren();
    feedbackEl.textContent = "";
    nextButton.hidden = true;
    resultEl.textContent = `Your score: ${score} / ${questions.length}`;
    restartButton.hidden = false;
  }
});

restartButton.addEventListener("click", () => {
  current = 0;
  score = 0;
  nextButton.hidden = false;
  resultEl.textContent = "";
  restartButton.hidden = true;
  showQuestion();
});

showQuestion();
