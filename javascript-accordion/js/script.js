document.addEventListener("DOMContentLoaded", function () {
  const questions = document.querySelectorAll(".question");

  questions.forEach(function (question) {
    const button = question.querySelector(".question__button");
    const questionText = question.querySelector(".question__title--text");

    button.addEventListener("click", function () {
      questions.forEach(function (q) {
        if (q !== question) {
          q.classList.remove("show-text");
        }
      });
      question.classList.toggle("show-text");
    });

    questionText.addEventListener("click", function () {
      questions.forEach(function (q) {
        if (q !== question) {
          q.classList.remove("show-text");
        }
      });
      question.classList.toggle("show-text");
    });
  });
});
