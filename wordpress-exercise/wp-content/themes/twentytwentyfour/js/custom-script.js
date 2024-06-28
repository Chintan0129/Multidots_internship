document.addEventListener("DOMContentLoaded", function () {
  var buttons = document.querySelectorAll(".show-inquiry-form-btn");
  buttons.forEach(function (button) {
    button.addEventListener("click", function () {
      var inquiryForm = this.nextElementSibling;
      if (inquiryForm.classList.contains("product-inquiry-form")) {
        if (
          inquiryForm.style.display === "none" ||
          inquiryForm.style.display === ""
        ) {
          inquiryForm.style.display = "block";
        } else {
          inquiryForm.style.display = "none";
        }
      }
    });
  });
});
