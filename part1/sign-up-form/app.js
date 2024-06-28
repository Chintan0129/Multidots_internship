const firstName = document.getElementById("firstname"),
  lastName = document.getElementById("lastname"),
  email = document.getElementById("email"),
  password = document.getElementById("password");

const form = document.getElementById("form");

const formControl = document.querySelectorAll(".form-control");
const errMessage = document.querySelectorAll(".err-message");

const inputArray = [firstName, lastName, email, password];

// Check Required Fields & Email Validity
function checkRequired(inputArray) {
  inputArray.forEach((input, index) => {
    if (input.value === "") {
      showError(input, index, `${input.placeholder} cannot be empty`);
    } else if (!formControl[index].classList.contains("mb")) {
      updateUI(input, index);
      showSuccess(input, index);
    } else {
      showSuccess(input, index);
      setTimeout(() => {
        input.value = "";
        input.classList.remove("success");
      }, 3000);
    }
  });
}

// Show Input Error Message
function showError(input, index, message) {
  input.nextElementSibling.classList.remove("hidden");
  input.classList.add("error");
  errMessage[index].classList.remove("hidden");
  errMessage[index].innerHTML = message;
  formControl[index].classList.remove("mb");
}

// Show Success Outline
function showSuccess(input) {
  input.classList.add("success");
}

// Reset Fields and Messages
function updateUI(input, index) {
  input.nextElementSibling.classList.add("hidden");
  input.classList.remove("error");
  errMessage[index].classList.add("hidden");
  formControl[index].classList.add("mb");
}

// Event Listeners
form.addEventListener("submit", (e) => {
  e.preventDefault();

  checkRequired(inputArray);
});
