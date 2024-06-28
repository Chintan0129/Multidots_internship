document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  const resetButton = document.getElementById("reset");
  const submitButton = document.getElementById("submit");

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    const answer1 = document.querySelector('input[name="answer"]:checked');
    const answer2 = document.querySelector('input[name="answer2"]:checked');
    const answer3 = document.querySelector('input[name="answer3"]:checked');
    const answer4 = document.querySelector('input[name="answer4"]:checked');
    const answer5 = document.querySelector('input[name="answer5"]:checked');

    if (!answer1 || !answer2 || !answer3 || !answer4 || !answer5) {
      alert("Please select an option for all questions.");
      return; // Prevent submission if any question is unanswered
    }

    let score = 0;
    let correctAnswer = 0;

    if (answer1.value === "seven") {
      score += 20;
      correctAnswer += 1;
      markCorrectOption(answer1);
    } else {
      markWrongOption(answer1);
    }

    if (answer2.value === "twofour") {
      score += 20;
      correctAnswer += 1;
      markCorrectOption(answer2);
    } else {
      markWrongOption(answer2);
    }

    if (answer3.value === "twosix") {
      score += 20;
      correctAnswer += 1;
      markCorrectOption(answer3);
    } else {
      markWrongOption(answer3);
    }

    if (answer4.value === "seven") {
      score += 20;
      correctAnswer += 1;
      markCorrectOption(answer4);
    } else {
      markWrongOption(answer4);
    }

    if (answer5.value === "delhi") {
      score += 20;
      correctAnswer += 1;
      markCorrectOption(answer5);
    } else {
      markWrongOption(answer5);
    }

    document.getElementById(
      "score"
    ).innerHTML = `Result: ${correctAnswer} out of 5 is correct. You achieved ${score}% score.`;
    document.getElementById("score").style.color = "red";
  });

  resetButton.addEventListener("click", function (option) {
    const allRadioButtons = document.querySelectorAll("input[type=radio]");
    allRadioButtons.forEach(function (radioButton) {
      radioButton.checked = false;
    });
    document.getElementById("score").innerHTML =
      "Note: Each question has 10 marks";
    document.getElementById("score").style.color = "#191D63";
    let correctAnswer = 0;
  });

  function markCorrectOption(option) {
    option.parentElement.classList.add("correct-option");
    setTimeout(() => {
      option.parentElement.classList.remove("correct-option");
    }, 5000);
  }

  function markWrongOption(option) {
    option.parentElement.classList.add("wrong-option");
    setTimeout(() => {
      option.parentElement.classList.remove("wrong-option");
    }, 5000);
  }

  // Check if all questions are answered before allowing submission
  function validateForm() {
    const answer1 = document.querySelector('input[name="answer"]:checked');
    const answer2 = document.querySelector('input[name="answer2"]:checked');
    const answer3 = document.querySelector('input[name="answer3"]:checked');
    const answer4 = document.querySelector('input[name="answer4"]:checked');
    const answer5 = document.querySelector('input[name="answer5"]:checked');

    if (!answer1 || !answer2 || !answer3 || !answer4 || !answer5) {
      alert("Please select an option for all questions.");
      return false;
    }
    return true;
  }

  submitButton.addEventListener("click", function (event) {
    if (!validateForm()) {
      event.preventDefault(); // Prevent form submission if validation fails
    }
  });
});
