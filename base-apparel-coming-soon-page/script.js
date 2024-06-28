const form = document.querySelector(".hero-banner__form"); //return the fetched form
const email = document.querySelector(".hero-banner__form .hero-banner__input"); //return the fetched input element

//trigger when submit the email
form.addEventListener("submit", (e) => {
  e.preventDefault();

  let emailValue = email.value; //fetch the input email

  if (validateEmail(emailValue)) {
    form.classList.remove("error"); //remove class if email is valid
  } else {
    form.classList.add("error"); //add class if email is not valid
  }
});

// validates the input email
function validateEmail(email) {
  var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}
