$(document).ready(function () {
  const $questions = $(".question");
  // Iterate over each question element
  $questions.each(function () {
    const $question = $(this);
    const $button = $question.find(".question__button");
    const $questionText = $question.find(".question__title--text");

    $button.on("click", function () {
      // Remove the "show-text" class from all question elements except the current one
      $questions.not($question).removeClass("show-text");
      // Toggle the "show-text" class on the current question element
      $question.toggleClass("show-text");
    });

    $questionText.on("click", function () {
      // Remove the "show-text" class from all question elements except the current one
      $questions.not($question).removeClass("show-text");
      // Toggle the "show-text" class on the current question element
      $question.toggleClass("show-text");
    });
  });
});
