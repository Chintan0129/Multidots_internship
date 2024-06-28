const form = document.querySelector("form");
const input = document.querySelector(".submitbutton");
const spanErr = document.querySelector(".error_msg");
console.log(spanErr);
input.addEventListener("invalid", () => {
  spanErr.classList.add("showError");
});
input.addEventListener("input", () => {
  spanErr.classList.remove("showError");
});
form.addEventListener("submit", (evt) => {
  console.log(evt);
  evt.preventDefault();
  alert("Your form has been submitted, Thank you");
  input.value = "";
});
