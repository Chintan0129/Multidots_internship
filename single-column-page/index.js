var emailInput = document.querySelector(".notify-input");
var invalidMessage = document.querySelector(".error-message");

function validateEmail() {
  var emailVal = emailInput.value;
  var mailFormat = /\S+@\S+\.\S+/;
  if (!emailVal.match(mailFormat)) {
    emailInput.classList.add("invalid-email");
    invalidMessage.style.display = "block";
  } else {
    if (emailInput.classList.contains("invalid-email")) {
      emailInput.classList.remove("invalid-email");
    }
    invalidMessage.style.display = "none";
  }
}
